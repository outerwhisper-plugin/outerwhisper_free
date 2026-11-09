import { config as globalConfig } from '../components/outerwhisper-form-config.js';
import { __ } from '../components/outerwhisper-i18n';
import { adminFeedbackList, initAdminFeedbackList } from '../components/outerwhisper-admin-feedback-list.js';

const outerwhisperAdmin = window.outerwhisperAdmin;

const state = {
    chartFeedback: null
};

const api = {
    async getChartRecentFeedbacks() {
        const formData = new FormData();
        formData.append('action', 'outerwhisper_get_chart_recent_feedbacks');
        formData.append('nonce', outerwhisperAdmin.nonce);

        try {
            const response = await fetch(outerwhisperAdmin.ajaxurl, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.success) {
                state.chartFeedback = result.data.feedback;
            } else {
                throw new Error(result.data);
            }
        } catch (error) {
            console.error('Refresh data error:', error);
            throw error;
        }
    },
};

const controller = {
    init: function() {
        this.setupDeleteConfirmation();
        this.setupPostboxToggles();
        initAdminFeedbackList();

        if (document.getElementById('outerwhisper-feedback-trend-chart')) {
            api.getChartRecentFeedbacks().then(() => {
                this.initTrendChart();
            }).catch(err => console.error(err));
        }
    },

    setupPostboxToggles: function() {
        if (typeof jQuery !== 'undefined' && typeof postboxes !== 'undefined') {
            postboxes.add_postbox_toggles('outerwhisper-about');
        }
    },

    initTrendChart: function() {
        const canvas = document.getElementById('outerwhisper-feedback-trend-chart');
        if (!canvas || !state.chartFeedback) return;

        const ctx = canvas.getContext('2d');
        const last30Days = [];
        const counts = [];
        const now = new Date();

        for (let i = 29; i >= 0; i--) {
            const d = new Date();
            d.setDate(now.getDate() - i);
            const dateStr = d.toISOString().split('T')[0];
            last30Days.push(d.toLocaleDateString(globalConfig.localeV2, { day: '2-digit', month: '2-digit' }));

            const dayCount = state.chartFeedback.filter(f => f.time && f.time.startsWith(dateStr)).length;
            counts.push(dayCount);
        }

        if (window.appTrendChart) window.appTrendChart.destroy();

        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded');
            return;
        }

        window.appTrendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: last30Days,
                datasets: [{
                    label: 'Feedback',
                    data: counts,
                    borderColor: '#2271b1',
                    backgroundColor: 'rgba(34, 113, 177, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
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
    api,
    controller,
    feedbackList: adminFeedbackList
};

export { state, api, controller, adminFeedbackList };
export default window.OUTERWHISPERAdmin;
