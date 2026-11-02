<?php
/**
 * Feedback score calculation helper.
 *
 * @package OuterWhisper
 */

namespace OuterWhisper\Helper;

defined('ABSPATH') || exit;

final class FeedbackScoreHelper
{
	public const RETURN_DEFAULT = 'default';
	public const RETURN_MERGED = 'merged';

	public const DIRECTION_POSITIVE = 'positive';
	public const DIRECTION_NEGATIVE = 'negative';

	/**
	 * Supported score field types.
	 *
	 * @var string[]
	 */
	private const SCORE_TYPES = [
		'rating',
	];

	/**
	 * Calculate feedback scores.
	 *
	 * Return modes:
	 * - default: Score summary and individual field scores.
	 * - merged: Original feedback data enriched with scores.
	 *
	 * @param array $feedback Stored feedback data.
	 * @param string $return_type Return mode.
	 * @return array
	 */
	public function calculate(
		array $feedback,
		string $return_type = self::RETURN_DEFAULT
	): array {
		if (!in_array(
			$return_type,
			[self::RETURN_DEFAULT, self::RETURN_MERGED],
			true
		)) {
			return [];
		}

		$merged = $feedback;
		$field_results = [];
		$scores = [];

		// Process Step 1.
		if (
			isset($merged['step1']) &&
			is_array($merged['step1'])
		) {
			foreach ($merged['step1'] as $index => $field) {
				$result = $this->process_field($field);

				if (null === $result) {
					continue;
				}

				if (null !== $result['score']) {
					$scores[] = $result['score'];
					$field_results[] = $result['summary'];
				}

				if (self::RETURN_MERGED === $return_type) {
					$merged['step1'][$index] = $result['field'];
				}
			}
		}

		// Process all Step 2 groups.
		if (
			isset($merged['step2']) &&
			is_array($merged['step2'])
		) {
			foreach ($merged['step2'] as $group_id => $group) {
				if (!is_array($group)) {
					continue;
				}

				foreach ($group as $index => $field) {
					$result = $this->process_field($field);

					if (null === $result) {
						continue;
					}

					if (null !== $result['score']) {
						$scores[] = $result['score'];
						$field_results[] = $result['summary'];
					}

					if (self::RETURN_MERGED === $return_type) {
						$merged['step2'][$group_id][$index] =
							$result['field'];
					}
				}
			}
		}

		$overall_score = $scores
			? round(array_sum($scores) / count($scores), 2)
			: null;

		$field_count = count($scores);

		if (self::RETURN_MERGED === $return_type) {
			$merged['score'] = $overall_score;
			$merged['score_field_count'] = $field_count;

			return $merged;
		}

		return [
			'score'       => $overall_score,
			'score_field_count' => $field_count,
			'fields'      => $field_results,
		];
	}

	/**
	 * Process one field without reference parameters.
	 *
	 * @param mixed $field Field data.
	 * @return array|null
	 */
	private function process_field($field): ?array
	{
		if (!is_array($field)) {
			return null;
		}

		$type = $field['type'] ?? '';

		if (!in_array($type, self::SCORE_TYPES, true)) {
			return null;
		}

		$score = null;

		if (
			array_key_exists('value', $field) &&
			$this->has_value($field['value'])
		) {
			$score = $this->calculate_field($field);
		}

		// Remove previously stored scores.
		unset($field['score']);

		// Add the newly calculated score if valid.
		if (null !== $score) {
			$field['score'] = $score;
		}

		return [
			'score'   => $score,
			'field'   => $field,
			'summary' => [
				'id'    => $field['id'] ?? '',
				'type'  => $type,
				'label' => $field['label'] ?? '',
				'value' => $field['value'] ?? null,
				'score' => $score,
			],
		];
	}

	/**
	 * Calculate the score of a single field,
	 * including its configured score direction.
	 *
	 * @param array $field Field configuration and value.
	 * @return float|null
	 */
	public function calculate_field(array $field): ?float
	{
		$type = $field['type'] ?? '';
		$value = $field['value'] ?? null;
		$settings = $field['settings'] ?? [];

		if (!is_array($settings)) {
			$settings = [];
		}

		$score = null;

		switch ($type) {
			case 'rating':
				$score = $this->calculate_rating(
					$value,
					$settings['stars'] ?? 5
				);
				break;

			default:
				return null;
		}

		return $this->apply_score_direction(
			$score,
			$settings['scoreDirection'] ?? self::DIRECTION_POSITIVE
		);
	}

	/**
	 * Apply score direction.
	 *
	 * positive: Higher values are better (default).
	 * negative: Higher values are worse.
	 *
	 * @param float|null $score Normalized score.
	 * @param mixed $direction Configured direction.
	 * @return float|null
	 */
	public function apply_score_direction(
		?float $score,
		$direction = self::DIRECTION_POSITIVE
	): ?float {
		if (null === $score) {
			return null;
		}

		if (self::DIRECTION_NEGATIVE === $direction) {
			return round(100 - $score, 2);
		}

		return $score;
	}

	/**
	 * Calculate a star rating score.
	 *
	 * 1 to N stars -> 0 to 100.
	 *
	 * @param mixed $value Selected rating.
	 * @param mixed $stars Maximum number of stars.
	 * @return float|null
	 */
	public function calculate_rating(
		$value,
		$stars = 5
	): ?float {
		$value = $this->numeric_value($value);
		$stars = $this->numeric_value($stars);

		if (
			null === $value ||
			null === $stars ||
			$stars < 2 ||
			$stars !== floor($stars) ||
			$value < 1 ||
			$value > $stars
		) {
			return null;
		}

		return round(
			(($value - 1) / ($stars - 1)) * 100,
			2
		);
	}

	/**
	 * Extract all fields with non-empty values from
	 * Step 1 and all Step 2 groups.
	 *
	 * @param array $feedback Stored feedback data.
	 * @return array
	 */
	public function get_fields(array $feedback): array
	{
		$fields = [];
		$groups = [];

		if (
			isset($steps['step1']) &&
			is_array($steps['step1'])
		) {
			$groups[] = $steps['step1'];
		}

		if (
			isset($steps['step2']) &&
			is_array($steps['step2'])
		) {
			foreach ($steps['step2'] as $group) {
				if (is_array($group)) {
					$groups[] = $group;
				}
			}
		}

		foreach ($groups as $group) {
			foreach ($group as $field) {
				if (
					is_array($field) &&
					array_key_exists('value', $field) &&
					$this->has_value($field['value'])
				) {
					$fields[] = $field;
				}
			}
		}

		return $fields;
	}

	/**
	 * Check whether a value is non-empty.
	 *
	 * Numeric zero and "0" are valid.
	 *
	 * @param mixed $value Submitted value.
	 * @return bool
	 */
	private function has_value($value): bool
	{
		if (null === $value) {
			return false;
		}

		if (is_string($value)) {
			return '' !== trim($value);
		}

		if (is_array($value)) {
			return !empty($value);
		}

		return true;
	}

	/**
	 * Convert a valid numeric value to float.
	 *
	 * @param mixed $value Input value.
	 * @return float|null
	 */
	private function numeric_value($value): ?float
	{
		if (
			!is_int($value) &&
			!is_float($value) &&
			!is_string($value)
		) {
			return null;
		}

		if (
			is_string($value) &&
			'' === trim($value)
		) {
			return null;
		}

		if (!is_numeric($value)) {
			return null;
		}

		$number = (float)$value;

		return is_finite($number) ? $number : null;
	}
}