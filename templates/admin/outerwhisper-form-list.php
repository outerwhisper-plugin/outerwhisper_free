<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<section id="outerwhisper-view-start" class="outerwhisper-view-section outerwhisper-form-list">
	<header class="outerwhisper-view-header flex-row">
		<h2 style="font-size: 24px; font-weight: 600; margin: 0 0 5px 0; color: var(--outerwhisper-primary-color);"><?php esc_html_e('admin.page.form_list.title', 'outerwhisper'); ?></h2>
		<a href="<?php echo esc_url(admin_url('admin.php?page=outerwhisper-form-builder')); ?>" class="page-title-action"><?php esc_html_e('admin.page.form_list.add_new', 'outerwhisper'); ?></a>
	</header>

	<?php if (!empty($isDuplicate)) : ?>
		<div class="updated notice is-dismissible">
			<p><?php esc_html_e( 'admin.page.form_list.notice.duplicate_success', 'outerwhisper' ); ?></p>
		</div>
	<?php endif; ?>

	<?php if (!empty($isDelete)) : ?>
		<div class="updated notice is-dismissible">
			<p><?php esc_html_e( 'admin.page.form_list.notice.delete_success', 'outerwhisper' ); ?></p>
		</div>
	<?php endif; ?>

	<?php if (!empty($formNotFound)) : ?>
		<div class="error notice is-dismissible">
			<p><?php esc_html_e( 'admin.page.form_list.notice.form_not_found', 'outerwhisper' ); ?></p>
		</div>
	<?php endif; ?>

	<form method="get">
		<input type="hidden" name="page" value="outerwhisper-forms" />
		<?php wp_nonce_field('outerwhisper_admin_nonce', 'nonce'); ?>
		<?php
		$form_table->display();
		?>
	</form>
</section>
