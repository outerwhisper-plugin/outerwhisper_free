import { adminFeedbackList, initAdminFeedbackList } from '../components/outerwhisper-admin-feedback-list.js';
import { adminDashboard, initDashboard } from '../components/outerwhisper-admin-dashboard.js';

import { __ } from '../components/outerwhisper-i18n';

const state = {
    chartFeedback: null
};

const controller = {
    init: function() {
        this.setupDeleteConfirmation();
        this.setupPostboxToggles();
        initDashboard();
        initAdminFeedbackList();
    },

    setupPostboxToggles: function() {
        if (typeof jQuery !== 'undefined' && typeof postboxes !== 'undefined') {
            postboxes.add_postbox_toggles('outerwhisper-about');
        }
    },

    setupDeleteConfirmation: function() {
        document.addEventListener('click', function(e) {
            const deleteLink = e.target.closest('.outerwhisper-delete-form-js');
            if (!deleteLink) return;

            const formName = deleteLink.getAttribute('data-name') || __('fields.unnamed');
            const message = __('admin.feedback.delete_form_confirm', { name: formName });

            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    },

    handleButtonClick: function(btn, status, successMessage, errorMessage = __('admin.feedback.delete_error'), preservedHtml = '') {
        if (!btn) return;

        if (status === 'loading') {
            const currentHtml = btn.innerHTML;
            btn.classList.add('loading');
            btn.innerHTML = `<div class="outerwhisper-spinner"></div> ${__('admin.feedback.saving')}`;
            return currentHtml;
        }

        if (status === 'success') {
            btn.classList.remove('loading');
            btn.classList.add('success');
            btn.innerHTML = `<i class="fas fa-check"></i> ${successMessage}`;
        } else if (status === 'error') {
            btn.classList.remove('loading');
            btn.classList.add('error');
            btn.innerHTML = `<i class="fas fa-times"></i> ${errorMessage}`;
        }

        setTimeout(() => {
            btn.classList.remove('success', 'error');
            if (preservedHtml) {
                btn.innerHTML = preservedHtml;
            }
        }, 1500);
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => controller.init());
} else {
    controller.init();
}

window.OUTERWHISPERAdmin = {
    init: () => controller.init(),
    state,
    controller,
    dashboard: adminDashboard,
    feedbackList: adminFeedbackList
};

export { state, controller, adminFeedbackList, adminDashboard };
export default window.OUTERWHISPERAdmin;
