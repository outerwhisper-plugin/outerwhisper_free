<?php
namespace OuterWhisper\Helper;

use OuterWhisper\Database\Entity\FormFeedback as FormFeedbackEntity;
use OuterWhisper\Database\Form as FormDB;
use OuterWhisper\Database\FormFeedback as FormFeedbackDB;

class FormFeedbackHelper {

	protected $fieldConfigs = [];

	public function __construct() {
		$configHelper = new ConfigHelper();
		$this->fieldConfigs = $configHelper->get_field_types_config();
	}

    /**
     * Bereitet die User-Daten für die Detailansicht auf.
     * Konsolidiert alle Steps in Step 1 und filtert nicht relevante Felder.
     */
    public function prepare_steps_for_detail_view(array $user_data) {
        if (!isset($user_data['steps'])) {
            return [];
        }

        $preparedUserValues = [];
        $active_step2_trigger_id = $user_data['active_step2_trigger_id'] ?? '';

        $steps = $user_data['steps'];
        $final_step1 = [];

        // 1. Step 1 Felder übernehmen
        if (isset($steps['step1']) && is_array($steps['step1'])) {
            $final_step1 = $this->filter_fields_for_detail_view($steps['step1'], $active_step2_trigger_id);
        }

        // 2. Alle Step 2 Felder ans Ende von Step 1 hängen
        if (isset($steps['step2']) && is_array($steps['step2'])) {
            foreach ($steps['step2'] as $trigger_id => $fields) {
                // Nur Felder anzeigen, die für active_step2_trigger_id definiert sind (falls gesetzt)
                if (!empty($active_step2_trigger_id) && $trigger_id !== $active_step2_trigger_id) {
                    continue;
                }

                if (is_array($fields)) {
                    $filtered_fields = $this->filter_fields_for_detail_view($fields, $active_step2_trigger_id);
                    foreach ($filtered_fields as $field) {
                        $final_step1[] = $field;
                    }
                }
            }
        }

        foreach ($final_step1 as $step) {
            if (!isset($step['value'])) {
                continue;
            }

            $preparedUserValues[$step['id']] = $step['value'];
        }

        // Resultat zusammenbauen
        $user_data = [
            'steps' => [
                'step1' => $final_step1
            ],
            'userValues' => $preparedUserValues
        ];

        return $user_data;
    }

	/**
	 * Bereitet alle Daten eines Feedbacks für das Detail-Template auf.
	 *
	 * @param array $feedback
	 * @return array|null
	 */
	public function get_detail_view_data(array $feedback): ?array {
		$feedbackId = $feedback['id'] ?? null;
		$feedbackEntity = $feedback['feedback_entity'] ?? null;

		if (empty($feedbackEntity) && (is_int($feedbackId) || is_numeric($feedbackId))) {
			$feedback_db = new FormFeedbackDB();
			$feedbackEntity = $feedback_db->get_feedback_by_id((int) $feedbackId);
		}

		if (!$feedbackEntity instanceof FormFeedbackEntity) {
			return null;
		}

		$decodedTrackingData = $feedbackEntity->getDecodedTrackingData();
		$user_data = $feedbackEntity->getDecodedFeedbackData();
		$prepared_data = $this->prepare_steps_for_detail_view($user_data);

		$form_db = new FormDB();
		$formData = $form_db->get_form($feedbackEntity->getFormId());

		$form_title = $formData ? $formData->getName() : ($user_data['title'] ?? '-');
		$first_question = $user_data['first_label_text'] ?? '-';

		$accent_color = '#000';
		if ($formData && !empty($formData->getDecodedPreviewData())) {
			$accent_color = $formData->getDecodedPreviewData()['settings']['styles']['accentColor'] ?? '#000';
		}

		// Betriebssystem erkennen
		$ua = $decodedTrackingData['userAgent'] ?? '';

		// User-Agent
		$trackUserAgent = $ua ?: '-';

		$prepared_tracking_data = [
			'useragent' => $trackUserAgent,
		];

		return [
			'feedback'               => $feedbackEntity,
			'user_data'              => $user_data,
			'steps'                  => $prepared_data['steps'] ?? [],
			'user_values'            => $prepared_data['userValues'] ?? [],
			'form_data'              => $formData,
			'form_title'             => $form_title,
			'first_question'         => $first_question,
			'accent_color'           => $accent_color,
			'tracking_data'          => $feedbackEntity->getDecodedTrackingData(),
			'prepared_tracking_data' => $prepared_tracking_data,
		];
	}

	public function render_rating($value, array $settings = []): string {
		$star_count = isset($settings['stars']) ? (int) $settings['stars'] : 5;
		$layout_type = isset($settings['layoutType']) ? $settings['layoutType'] : 'default';
		if ($star_count < 1) {
			$star_count = 5;
		}

		$clicked_star_index = (null !== $value && '' !== $value) ? ((int) $value - 1) : -1;

		$style = '';
		if ($layout_type === 'table-row') {
			$style = 'font-size: 20px;';
		}

		$html = '<div class="outerwhisper-fd-stars-row"' . (!empty($style) ? ' style="' . $style . '"' : '') . '>';
		for ($s = 1; $s <= $star_count; $s++) {
			$is_active = ($s - 1 <= $clicked_star_index);
			$color = $is_active ? '#555555' : '#cbd5e1';
			$icon_class = $is_active ? 'fas fa-star' : 'far fa-star';

			$html .= '<span class="outerwhisper-fd-star" style="color: ' . $color . '; cursor: default;">';
			$html .= '<i class="' . $icon_class . '" style="pointer-events: none;"></i>';
			$html .= '</span>';
		}
		$html .= '</div>';

		return $html;
	}

	public function prepareFirstAnswerPreview(string $firstAnswer, string $firstAnswerFieldType, string $type = '') {
		$preparedFirstAnswer = esc_html(wp_trim_words($firstAnswer, 15, '...'));

		switch ($firstAnswerFieldType) {
			case 'rating':
				$preparedFirstAnswer = $this->render_rating($firstAnswer, ['layoutType' => $type]);
				break;
		}

		return $preparedFirstAnswer;
	}

    /**
     * Filtert eine Liste von Feldern für die Detailansicht.
     * Felder mit userinput=true werden entfernt, wenn kein "value" gesetzt ist.
     * Ausnahme: Das Feld mit der ID $active_step2_trigger_id wird immer angezeigt.
     */
    protected function filter_fields_for_detail_view(array $fields, string $active_step2_trigger_id = ''): array {
        $field_configs = $this->fieldConfigs;

        return array_values(array_filter($fields, function($field) use ($field_configs, $active_step2_trigger_id) {
            $type = $field['type'] ?? '';
            $config = $field_configs[$type] ?? null;

            if (!$config) {
                return false;
            }

            // Wenn es sich um den active_step2_trigger_id handelt, immer anzeigen (wenn config vorhanden)
            if (!empty($active_step2_trigger_id) && isset($field['id']) && $field['id'] === $active_step2_trigger_id) {
                return true;
            }

            // Wenn userinput benötigt wird, muss ein value vorhanden sein
            if (isset($config['userinput']) && $config['userinput'] === true) {
                return array_key_exists('value', $field);
            }

            return true;
        }));
    }
}
