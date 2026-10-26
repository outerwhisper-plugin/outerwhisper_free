<?php
if (!defined('ABSPATH')) {
	exit;
}

if (!\OuterWhisper\EnvironmentChecks::check()) {
    include OUTERWHISPER_PLUGIN_PATH . 'templates/admin/outerwhisper-admin-env-error.php';

    return;
}

?>
<div class="wrap">
    <div id="outerwhisper-feedback-admin" class="outerwhisper-admin-container <?php echo esc_attr($page)?>">
        <h1 class="wp-heading-inline" style="display:none;"></h1>
        <hr class="wp-header-end" style="display:none;">

        <nav class="outerwhisper-admin-nav">
            <div class="outerwhisper-nav-brand">
                <i class="fas fa-comment-dots"></i>
                <span><?php esc_html_e('admin.horizontal_navigation.brand', 'outerwhisper'); ?></span>
            </div>
            <ul class="outerwhisper-nav-tabs">
                <li class="outerwhisper-nav-item <?php echo ($page === 'outerwhisper-dashboard') ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=outerwhisper-dashboard&nonce=' . $nonce)); ?>">
                        <i class="fas fa-home"></i> <?php esc_html_e('admin.horizontal_navigation.dashboard', 'outerwhisper'); ?>
                    </a>
                </li>
                <li class="outerwhisper-nav-item <?php echo ($page === 'outerwhisper-forms') ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=outerwhisper-forms&nonce=' . $nonce)); ?>">
                        <i class="fas fa-file-alt"></i> <?php esc_html_e('admin.horizontal_navigation.all_forms', 'outerwhisper'); ?>
                    </a>
                </li>
                <li class="outerwhisper-nav-item <?php echo ($page === 'outerwhisper-form-builder' && empty($id)) ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=outerwhisper-form-builder&nonce=' . $nonce)); ?>">
                        <i class="fas fa-plus-circle"></i> <?php esc_html_e('admin.horizontal_navigation.add_form', 'outerwhisper'); ?>
                    </a>
                </li>
                <li class="outerwhisper-nav-item <?php echo ($page === 'outerwhisper-form-feedbacks') ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=outerwhisper-form-feedbacks&nonce=' . $nonce)); ?>">
                        <i class="fas fa-list"></i> <?php esc_html_e('admin.horizontal_navigation.feedback_list', 'outerwhisper'); ?>
                    </a>
                </li>
                <li class="outerwhisper-nav-item <?php echo ($page === 'outerwhisper-export') ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=outerwhisper-export&nonce=' . $nonce)); ?>">
                        <i class="fas fa-file-export"></i> <?php esc_html_e('admin.horizontal_navigation.export', 'outerwhisper'); ?>
                    </a>
                </li>
                <li class="outerwhisper-nav-item <?php echo ($page === 'outerwhisper-about') ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=outerwhisper-about&nonce=' . $nonce)); ?>">
                        <i class="fas fa-info-circle"></i> <?php esc_html_e('admin.horizontal_navigation.about', 'outerwhisper'); ?>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="outerwhisper-admin-content" id="outerwhisper-main-content">
            <?php
            if (isset($admin_template) && file_exists($admin_template)) {
                include $admin_template;
            }
            ?>
        </div>
    </div>

</div>

