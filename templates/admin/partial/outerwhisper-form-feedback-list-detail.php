<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Partial: outerwhisper-form-feedback-list-detail.php
 *
 * @var \OuterWhisper\Database\Entity\FormFeedback|null $feedback
 * @var array $user_data
 * @var array $steps
 * @var array $user_values
 * @var \OuterWhisper\Database\Entity\Form|null $form_data
 * @var string $form_title
 * @var string $first_question
 * @var string $accent_color
 * @var array $tracking_data
 * @var array $prepared_tracking_data
 * @var \OuterWhisper\Helper\FormFeedbackHelper|null $outerwhisperFeedbackHelper
 */
$outerwhisperFeedbackHelper = new \OuterWhisper\Helper\FormFeedbackHelper();

if (!isset($feedback) || !$feedback instanceof \OuterWhisper\Database\Entity\FormFeedback) {
	?>
	<div class="outerwhisper-feedback-drawer-empty" style="padding: 32px; text-align: center; color: var(--outerwhisper-feedback-text-muted);">
		<i class="fa-regular fa-comment-dots" style="font-size: 32px; margin-bottom: 12px; display: block;" aria-hidden="true"></i>
		<p style="margin: 0; font-size: 14px;"><?php esc_html_e('admin.page.feedback_list.detail.no_feedback_selected', 'outerwhisper'); ?></p>
	</div>
	<?php
	return;
}

$outerwhisperValidHtmlTags = ['div' => ['class'], 'span', ['class', 'style'], 'i' => ['class', 'style'], 'p' => [], 'button' => []];

$outerwhisperFeedbackId     = $feedback->getId();
$outerwhisperFeedbackStatus = $feedback->getStatus();
$outerwhisperFeedbackScore  = $feedback->getFeedbackScore();
$outerwhisperFeedbackCreatedDate    = $feedback->getCreated();
$outerwhisperFeedbackFormattedDate  = !empty($outerwhisperFeedbackCreatedDate) ? date_i18n(get_option('date_format') . ', ' . get_option('time_format'), strtotime($outerwhisperFeedbackCreatedDate)) : '-';
$outerwhisperFeedbackDisplayType    = ucfirst($feedback->getFormType());
$outerwhisperFeedbackPageUrl        = $feedback->getTrackingPageUrl();
$outerwhisperFeedbackPagePath       = !empty($outerwhisperFeedbackPageUrl) ? (wp_parse_url($outerwhisperFeedbackPageUrl, PHP_URL_PATH) ?: $outerwhisperFeedbackPageUrl) : '';

$outerwhisperStatusLabel = esc_html__('admin.page.feedback_list.modal.status.unread', 'outerwhisper');
if ('read' === $outerwhisperFeedbackStatus) {
	$outerwhisperStatusLabel = esc_html__('admin.page.feedback_list.modal.status.read', 'outerwhisper');
} elseif ('archived' === $outerwhisperFeedbackStatus) {
	$outerwhisperStatusLabel = esc_html__('admin.page.feedback_list.modal.status.archived', 'outerwhisper');
}

$outerwhisperScoreBadgeClass = '';
if (null !== $outerwhisperFeedbackScore) {
	$outerwhisperNumericScore = round((float) $outerwhisperFeedbackScore);
	if ($outerwhisperNumericScore >= 75) {
		$outerwhisperScoreBadgeClass = 'outerwhisper-feedback-score-high';
	} elseif ($outerwhisperNumericScore >= 50) {
		$outerwhisperScoreBadgeClass = 'outerwhisper-feedback-score-mid';
	} else {
		$outerwhisperScoreBadgeClass = 'outerwhisper-feedback-score-low';
	}
}
?>

<header class="outerwhisper-feedback-drawer-header">
	<div class="outerwhisper-feedback-drawer-title-row">
		<h2 id="outerwhisper-feedback-drawer-id" class="outerwhisper-feedback-drawer-title">
			<?php printf(esc_html__('admin.page.feedback_list.detail.title', 'outerwhisper'), (int) $outerwhisperFeedbackId); ?>

			<?php if (null !== $outerwhisperFeedbackScore) : ?>
				<span id="outerwhisper-feedback-drawer-score" class="outerwhisper-feedback-drawer-score-badge <?php echo esc_attr($outerwhisperScoreBadgeClass); ?>">
					<strong><?php echo esc_html((string) round($outerwhisperFeedbackScore, 1)); ?></strong> / 100
				</span>
			<?php endif; ?>
		</h2>
	</div>
	<div class="outerwhisper-status-segmented-control" id="outerwhisper-modal-status-control">
		<button type="button" class="outerwhisper-status-btn <?php echo esc_attr($outerwhisperFeedbackStatus === 'unread' ? 'active' : ''); ?>" data-status="unread">
			<i class="far fa-envelope"></i> <?php esc_html_e('admin.page.feedback_list.status.unread', 'outerwhisper') ?>
		</button>
		<button type="button" class="outerwhisper-status-btn <?php echo esc_attr($outerwhisperFeedbackStatus === 'read' ? 'active' : ''); ?>" data-status="read">
			<i class="far fa-envelope-open"></i> <?php esc_html_e('admin.page.feedback_list.status.read', 'outerwhisper') ?>
		</button>
		<button type="button" class="outerwhisper-status-btn <?php echo esc_attr($outerwhisperFeedbackStatus === 'archived' ? 'active' : ''); ?>" data-status="archived">
			<i class="fas fa-archive"></i> <?php esc_html_e('admin.page.feedback_list.status.archived', 'outerwhisper') ?>
		</button>
	</div>
</header>

<section class="outerwhisper-feedback-drawer-section">
	<h3 class="outerwhisper-feedback-section-heading">
		<i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
		<span><?php esc_html_e('admin.page.feedback_list.detail.general_info', 'outerwhisper'); ?></span>
	</h3>
	<table class="outerwhisper-feedback-info-table">
		<tbody>
			<tr>
				<th scope="row"><?php esc_html_e('admin.form_list.filter.form', 'outerwhisper'); ?></th>
				<td id="outerwhisper-feedback-detail-form"><?php echo esc_html($form_title); ?></td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e('admin.page.feedback_list.detail.topic', 'outerwhisper'); ?></th>
				<td id="outerwhisper-feedback-detail-question"><?php echo esc_html($first_question); ?></td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e('admin.form_list.display_type', 'outerwhisper'); ?></th>
				<td id="outerwhisper-feedback-detail-display"><?php echo esc_html($outerwhisperFeedbackDisplayType); ?></td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e('admin.form_list.page_url', 'outerwhisper'); ?></th>
				<td>
					<?php if (!empty($outerwhisperFeedbackPageUrl)) : ?>
						<a id="outerwhisper-feedback-detail-url" href="<?php echo esc_url($outerwhisperFeedbackPageUrl); ?>" target="_blank" rel="noopener noreferrer" class="outerwhisper-feedback-ext-link" title="<?php echo esc_attr($outerwhisperFeedbackPageUrl); ?>">
							<span><?php echo esc_html($outerwhisperFeedbackPagePath); ?></span>
							<i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
						</a>
					<?php else : ?>
						<span>-</span>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e('admin.form_list.created', 'outerwhisper'); ?></th>
				<td id="outerwhisper-feedback-detail-date"><?php echo esc_html($outerwhisperFeedbackFormattedDate); ?></td>
			</tr>
		</tbody>
	</table>
</section>

<section class="outerwhisper-feedback-drawer-section">
	<h3 class="outerwhisper-feedback-section-heading">
		<i class="fa-regular fa-comments" aria-hidden="true"></i>
		<span><?php esc_html_e('admin.page.feedback_list.detail.answers', 'outerwhisper'); ?></span>
	</h3>

	<?php
	$outerwhisperFields = $steps['step1'] ?? [];
	if (!empty($outerwhisperFields) && is_array($outerwhisperFields)) :
		foreach ($outerwhisperFields as $outerwhisperField) :
			$outerwhisperField_type  = $outerwhisperField['type'] ?? '';
			$outerwhisperField_label = $outerwhisperField['label'] ?? '-';
			$outerwhisperField_val   = $outerwhisperField['value'] ?? ($user_values[$outerwhisperField['id'] ?? ''] ?? null);

			if (null === $outerwhisperField_val || '' === $outerwhisperField_val) {
				continue;
			}
			?>
			<div class="outerwhisper-feedback-answer-card outerwhisper-feedback-plugin">
				<div class="outerwhisper-feedback-answer-question">
					<?php if ('rating' === $outerwhisperField_type) : ?>
						<i class="fa-regular fa-star" aria-hidden="true"></i>
					<?php else : ?>
						<i class="fa-regular fa-comment-dots" aria-hidden="true"></i>
					<?php endif; ?>
					<span><?php echo esc_html($outerwhisperField_label); ?></span>
				</div>

				<?php
				if ('rating' === $outerwhisperField_type) : ?>
					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is escaped inside the rendering helper.
					echo $outerwhisperFeedbackHelper->render_rating($outerwhisperField_val, $outerwhisperField['settings'] ?? []); ?>
				<?php elseif (is_array($outerwhisperField_val)) : ?>
					<div class="outerwhisper-feedback-answer-text-box">
						<?php echo esc_html(implode(', ', array_map('strval', $outerwhisperField_val))); ?>
					</div>
				<?php else :?>
					<div class="outerwhisper-feedback-answer-text-box">
						<?php echo nl2br(esc_html((string) $outerwhisperField_val)); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php
		endforeach;
	else :
		?>
		<p style="font-size: 13px; color: var(--outerwhisper-feedback-text-muted); margin: 0;"><?php esc_html_e('admin.page.feedback_list.detail.no_answers', 'outerwhisper'); ?></p>
	<?php endif; ?>
</section>

<section class="outerwhisper-feedback-drawer-section">
	<h3 class="outerwhisper-feedback-section-heading">
		<i class="fa-solid fa-laptop-code" aria-hidden="true"></i>
		<span><?php esc_html_e('admin.page.feedback_list.modal.tracking.title', 'outerwhisper'); ?></span>
	</h3>
	<table class="outerwhisper-feedback-info-table">
		<tbody>
			<tr>
				<th scope="row"><?php esc_html_e('admin.page.feedback_list.detail.user_agent', 'outerwhisper'); ?></th>
				<td class="outerwhisper-feedback-tracking-data-text-box"><?php echo esc_html($prepared_tracking_data['useragent']); ?></td>
			</tr>
		</tbody>
	</table>
</section>

<section class="outerwhisper-feedback-drawer-section">
	<div class="outerwhisper-raw-data-section">
		<button class="outerwhisper-feedback-section-heading outerwhisper-raw-toggle-btn" id="outerwhisper-btn-raw-toggle" type="button" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 4px 6px; border-radius: 4px; transition: background 0.2s;">
			<span style="font-weight: 700;" title="<?php echo esc_attr__('admin.page.feedback_list.modal.json_data', 'outerwhisper'); ?>"><i class="fas fa-code" style="margin-right: 6px;"></i> <?php esc_html_e('admin.page.feedback_list.modal.json_data', 'outerwhisper'); ?></span>
			<i class="fas fa-chevron-down" id="outerwhisper-raw-chevron"></i>
		</button>
		<pre class="outerwhisper-raw-json-pre hidden" id="outerwhisper-raw-json-block" style="background: #1e293b; color: #38bdf8; font-family: monospace; font-size: 0.75rem; padding: 12px; border-radius: 6px; margin-top: 10px; max-height: 150px; overflow-y: auto; text-align: left;"><?php echo esc_html(!empty($tracking_data) ? wp_json_encode($tracking_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : '{}'); ?></pre>
	</div>
</section>

<footer class="outerwhisper-feedback-drawer-footer">
	<button type="button" id="outerwhisper-feedback-btn-trash" class="outerwhisper-feedback-trash-btn" data-id="<?php echo esc_attr((string) $outerwhisperFeedbackId); ?>">
		<i class="fa-regular fa-trash-can" aria-hidden="true"></i>
		<span><?php esc_html_e('admin.page.feedback_list.detail.trash', 'outerwhisper'); ?></span>
	</button>
	<div class="outerwhisper-feedback-drawer-nav">
		<button type="button" id="outerwhisper-feedback-prev-item" class="outerwhisper-feedback-drawer-nav-btn" aria-label="<?php esc_attr_e('admin.page.feedback_list.detail.prev_feedback', 'outerwhisper'); ?>">
			<i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
		</button>
		<button type="button" id="outerwhisper-feedback-next-item" class="outerwhisper-feedback-drawer-nav-btn" aria-label="<?php esc_attr_e('admin.page.feedback_list.detail.next_feedback', 'outerwhisper'); ?>">
			<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
		</button>
	</div>
</footer>
