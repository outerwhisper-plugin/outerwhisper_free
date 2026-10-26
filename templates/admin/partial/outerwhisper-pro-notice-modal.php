<?php
if (!defined('ABSPATH')) {
	exit;
}

$outerwhisperFinalProNoticeHeadline = (!empty($outerwhisperProNoticeHeadline) ? $outerwhisperProNoticeHeadline : __('admin.builder.pro.headline', 'outerwhisper'));
$outerwhisperFinalProNoticeIntro = (!empty($outerwhisperProNoticeIntro) ? $outerwhisperProNoticeIntro : __('admin.builder.pro.intro', 'outerwhisper'));
$outerwhisperFinalProNoticeAdvantages = $outerwhisperProNoticeAdvantages ?? [
	esc_html__('admin.builder.pro.advantage.1', 'outerwhisper'),
	esc_html__('admin.builder.pro.advantage.2', 'outerwhisper'),
	esc_html__('admin.builder.pro.advantage.3', 'outerwhisper')
];

?>

<!-- PRO / Freemius Upgrade Modal -->
<div id="outerwhisper-modal-pro-upgrade" class="outerwhisper-form-builder outerwhisper-modal-overlay outerwhisper-modal-overlay-active" role="dialog" aria-modal="true" aria-labelledby="outerwhisper-pro-title">
	<div class="outerwhisper-modal-box" style="max-width: 500px;">
		<div class="outerwhisper-modal-header" style="background-color: var(--outerwhisper-primary-light); border-bottom: 1px solid var(--outerwhisper-border); padding: 16px 24px; border-top-left-radius: 12px; border-top-right-radius: 12px;">
			<h3 class="outerwhisper-modal-title" id="outerwhisper-pro-title" style="color: var(--outerwhisper-primary); font-weight: 700;">
				<i class="fas fa-crown" style="color: var(--outerwhisper-warning);"></i> <?php esc_html_e('admin.builder.pro.title', 'outerwhisper'); ?>
			</h3>
		</div>
		<div class="outerwhisper-modal-body" style="padding: 24px;">
			<div style="text-align: center; margin-bottom: 24px;">
				<div style="font-size: 48px; margin-bottom: 12px; color: var(--outerwhisper-warning);">
					<i class="fas fa-gem"></i>
				</div>
				<h4 style="font-size: 18px; font-weight: 700; color: var(--outerwhisper-text); margin-bottom: 8px;"><?php echo esc_html($outerwhisperFinalProNoticeHeadline) ?></h4>
				<p style="color: var(--outerwhisper-text-secondary); font-size: 13.5px; line-height: 1.5; margin: 0;">
					<?php echo wp_kses($outerwhisperFinalProNoticeIntro, ['strong' => []]) ?>
				</p>
			</div>

			<div style="background-color: var(--outerwhisper-bg); border: 1px solid var(--outerwhisper-border); border-radius: 8px; padding: 16px; margin-bottom: 4px;">
				<h5 style="font-weight: 700; font-size: 13px; color: var(--outerwhisper-text); margin-bottom: 12px; margin-top: 0; text-transform: uppercase; letter-spacing: 0.05em;"><?php esc_html_e('admin.builder.pro.advantages_title', 'outerwhisper'); ?></h5>
				<ul style="list-style: none; display: flex; flex-direction: column; gap: 10px; font-size: 13px; padding-left: 0; margin: 0;">
					<?php foreach ($outerwhisperFinalProNoticeAdvantages as $outerwhisperProAdvantage) : ?>
						<li style="display: flex; align-items: flex-start; gap: 8px; color: var(--outerwhisper-text);">
							<i class="fas fa-check-circle" style="color: var(--outerwhisper-success); margin-top: 2px;"></i>
							<span><?php echo esc_html($outerwhisperProAdvantage) ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="outerwhisper-modal-footer" style="padding: 16px 24px; border-top: 1px solid var(--outerwhisper-border); display: flex; justify-content: center; gap: 12px; background-color: var(--outerwhisper-bg); border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
			<a href="<?php echo esc_url('https://outerwhisper.de') ?>" target="_blank" class="outerwhisper-btn" id="outerwhisper-btn-pro-upgrade-cta" style="background-color: var(--outerwhisper-primary); color: white; font-weight: 600; padding: 8px 20px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; border: 1px solid var(--outerwhisper-primary); box-shadow: var(--outerwhisper-shadow-md); transition: all 0.2s; height: auto;">
				<i class="fas fa-shopping-cart"></i> <?php esc_html_e('admin.builder.pro.cta_text', 'outerwhisper'); ?>
			</a>
		</div>
	</div>
</div>