/**
 * Admin Feedback List Management
 */

import { __ } from './outerwhisper-i18n.js';

export const adminFeedbackList = {
    currentFeedbackId: null,
    currentFeedbackStatus: 'unread',
    isLoading: false,

    init: function() {
        this.initFilterBar();
        this.initTableRowListeners();
        this.initDrawerEvents();
        this.highlightInitialRow();
    },

    initFilterBar: function() {
        const filterForm = document.getElementById('outerwhisper-feedback-list-form');
        if (!filterForm) {
            return;
        }

        const filterSelects = filterForm.querySelectorAll('.outerwhisper-feedback-filter-bar select');
        filterSelects.forEach(select => {
            select.addEventListener('change', () => {
                filterForm.submit();
            });
        });
    },

    initTableRowListeners: function() {
        const table = document.querySelector('.outerwhisper-feedback-list-table');
        if (!table) {
            return;
        }

        table.addEventListener('click', (event) => {
            const targetCell = event.target.closest('.column-id, .column-status,.column-score, .column-form, .column-answer, .column-date, .column-action');
            if (!targetCell) {
                return;
            }

            if (event.target.closest('a, input[type="checkbox"], button')) {
                return;
            }

            const row = targetCell.closest('tr.outerwhisper-feedback-row');
            if (!row) {
                return;
            }

            const feedbackId = row.getAttribute('data-id');
            if (feedbackId) {
                this.fetchFeedbackDetails(feedbackId, row);
            }
        });
    },

    fetchFeedbackDetails: async function(feedbackId, targetRow = null) {
        if (!feedbackId || this.isLoading) {
            return;
        }

        const drawer = document.getElementById('outerwhisper-feedback-detail-drawer');
        if (!drawer) {
            return;
        }

        const activeRow = targetRow || document.querySelector(`tr.outerwhisper-feedback-row[data-id="${feedbackId}"]`);
        if (!activeRow) {
            return;
        }

        const activeRowStatus = activeRow.getAttribute('data-status') || 'unread';

        this.isLoading = true;
        this.currentFeedbackId = feedbackId;
        this.currentFeedbackStatus = activeRowStatus;
        this.setActiveRow(activeRow);

        const cacheKey = `outerwhisper_feedback_detail_${feedbackId}_${activeRowStatus}`;
        try {
            const cached = sessionStorage.getItem(cacheKey);
            if (cached) {
                const parsed = JSON.parse(cached);
                const data = parsed.data || parsed;
                if (data && data.html) {
                    this.renderDrawerContent(drawer, data.html);
                    this.isLoading = false;
                    return;
                }
            }
        } catch (e) {
            sessionStorage.removeItem(cacheKey);
        }

        this.setDrawerLoading(drawer, true);

        const adminConfig = window.outerwhisperAdmin || {};
        const ajaxUrl = adminConfig.ajaxurl || '/wp-admin/admin-ajax.php';
        const nonce = adminConfig.nonce || '';

        const url = new URL(ajaxUrl, window.location.origin);
        url.searchParams.append('action', 'outerwhisper_get_form_feedback_by_id');
        url.searchParams.append('nonce', nonce);
        url.searchParams.append('id', feedbackId);

        try {
            const response = await fetch(url.toString());
            const result = await response.json();

            if (result.success && result.data && result.data.html) {
                try {
                    sessionStorage.setItem(cacheKey, JSON.stringify(result));
                } catch (e) {}
                this.renderDrawerContent(drawer, result.data.html);
            } else {
                console.error('[OUTERWHISPER] Failed to load feedback details:', result);
            }
        } catch (error) {
            console.error('[OUTERWHISPER] Network error while fetching feedback details:', error);
        } finally {
            this.isLoading = false;
            this.setDrawerLoading(drawer, false);
        }
    },

    renderDrawerContent: function(drawer, html) {
        if (!drawer) return;
        drawer.innerHTML = html;
        this.initDrawerEvents();
    },

    setDrawerLoading: function(drawer, loading) {
        if (!drawer) return;
        if (loading) {
            drawer.classList.add('is-loading');
        } else {
            drawer.classList.remove('is-loading');
        }
    },

    setActiveRow: function(row) {
        const allRows = document.querySelectorAll('.outerwhisper-feedback-list-table tbody tr.outerwhisper-feedback-row');
        allRows.forEach(r => r.classList.remove('outerwhisper-feedback-row-selected'));

        if (row) {
            row.classList.add('outerwhisper-feedback-row-selected');
        }
    },

    highlightInitialRow: function() {
        const drawerTrashBtn = document.getElementById('outerwhisper-feedback-btn-trash');
        const initialId = drawerTrashBtn ? drawerTrashBtn.getAttribute('data-id') : null;
        if (initialId) {
            const row = document.querySelector(`tr.outerwhisper-feedback-row[data-id="${initialId}"]`);
            if (row) {
                this.setActiveRow(row);
                this.currentFeedbackId = initialId;
            }
        }
    },

    initDrawerEvents: function() {
        const drawer = document.getElementById('outerwhisper-feedback-detail-drawer');
        if (!drawer) return;

        const prevBtn = drawer.querySelector('#outerwhisper-feedback-prev-item');
        const nextBtn = drawer.querySelector('#outerwhisper-feedback-next-item');

        if (prevBtn) {
            prevBtn.onclick = () => this.navigateDrawer(-1);
        }
        if (nextBtn) {
            nextBtn.onclick = () => this.navigateDrawer(1);
        }

        const trashBtn = drawer.querySelector('#outerwhisper-feedback-btn-trash');
        if (trashBtn) {
            trashBtn.onclick = () => {
                const feedbackId = trashBtn.getAttribute('data-id') || this.currentFeedbackId;
                if (feedbackId) {
                    this.deleteFeedback(feedbackId);
                }
            };
        }

        const btnRawToggle = drawer.querySelector('#outerwhisper-btn-raw-toggle');
        const rawBlock = drawer.querySelector('#outerwhisper-raw-json-block');
        const rawChevron = drawer.querySelector('#outerwhisper-raw-chevron');
        if (btnRawToggle && rawBlock) {
            btnRawToggle.onclick = () => {
                const isHidden = rawBlock.classList.contains('hidden');
                if (isHidden) {
                    rawBlock.classList.remove('hidden');
                    if (rawChevron) rawChevron.className = 'fas fa-chevron-up';
                } else {
                    rawBlock.classList.add('hidden');
                    if (rawChevron) rawChevron.className = 'fas fa-chevron-down';
                }
            };
        }

        const statusButtons = drawer.querySelectorAll('#outerwhisper-modal-status-control .outerwhisper-status-btn');
        const currentStatus = this.currentFeedbackStatus || '';
        let isStatusAnimating = false;

        statusButtons.forEach(btn => {
            const btnStatus = btn.getAttribute('data-status');
            if (this.currentFeedbackId !== null) {
                if (btnStatus === currentStatus) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            }

            btn.onclick = () => {
                if (isStatusAnimating) return;
                if (btn.classList.contains('active')) return;

                isStatusAnimating = true;

                const icon = btn.querySelector('i');
                const originalIconClass = icon ? icon.className : '';

                if (icon) {
                    icon.className = 'fas fa-spinner fa-spin';
                }

                const formData = new FormData();
                formData.append('action', 'outerwhisper_update_form_feedback_status');
                formData.append('nonce', outerwhisperAdmin.nonce);
                formData.append('feedback_id', this.currentFeedbackId);
                formData.append('status', btnStatus);

                fetch(outerwhisperAdmin.ajaxurl, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(result => {
                        setTimeout(() => {
                            if (result.success) {
                                statusButtons.forEach(b => {
                                    b.classList.remove('active');
                                    const otherIcon = b.querySelector('i');
                                    if (otherIcon) {
                                        otherIcon.classList.remove('outerwhisper-fade-in');
                                    }
                                });

                                btn.classList.add('active');

                                const feedbackRow = document.querySelector(`.wp-list-table tbody tr[data-id="${this.currentFeedbackId}"]`);
                                if (feedbackRow && feedbackRow.querySelector('.column-status')) {
                                    feedbackRow.dataset.status = btnStatus;

                                    const statusCol = feedbackRow.querySelector('.column-status');
                                    if (statusCol) {
                                        let statusLabel = '';
                                        switch (btnStatus) {
                                            case 'read':
                                                statusLabel = __('admin.form_list.filter.status.read');
                                                break;
                                            case 'archived':
                                                statusLabel = __('admin.form_list.filter.status.archived');
                                                break;
                                            case 'unread':
                                            default:
                                                statusLabel = __('admin.form_list.filter.status.unread');
                                                break;
                                        }

                                        statusCol.innerHTML = `<span class="outerwhisper-feedback-status-pill outerwhisper-feedback-status-${btnStatus}">${statusLabel.charAt(0).toUpperCase() + statusLabel.slice(1)}</span>`;
                                    }
                                }
                            } else {
                                alert(result.data || __('admin.feedback.status_update_error'));
                            }

                            if (icon) {
                                icon.className = originalIconClass + ' outerwhisper-fade-in';
                                setTimeout(() => {
                                    icon.classList.remove('outerwhisper-fade-in');
                                }, 350);
                            }

                            isStatusAnimating = false;
                        }, 400);
                    })
                    .catch(error => {
                        console.error('Error updating status:', error);
                        if (icon) icon.className = originalIconClass;
                        isStatusAnimating = false;
                    });
            };
        });
    },

    deleteFeedback: async function(feedbackId) {
        if (!feedbackId || this.isLoading) {
            return;
        }

        const confirmMsg = __('admin.feedback.delete_confirm', { id: feedbackId });
        if (!window.confirm(confirmMsg)) {
            return;
        }

        const drawer = document.getElementById('outerwhisper-feedback-detail-drawer');
        const adminConfig = window.outerwhisperAdmin || {};
        const ajaxUrl = adminConfig.ajaxurl || '/wp-admin/admin-ajax.php';
        const nonce = adminConfig.nonce || '';

        this.isLoading = true;
        this.setDrawerLoading(drawer, true);

        const formData = new FormData();
        formData.append('action', 'outerwhisper_delete_feedback');
        formData.append('nonce', nonce);
        formData.append('id', feedbackId);

        let nextTargetId = null;
        let nextTargetRow = null;

        try {
            const response = await fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                try {
                    sessionStorage.removeItem(`outerwhisper_feedback_${feedbackId}`);
                } catch (e) {}

                const rows = Array.from(document.querySelectorAll('.outerwhisper-feedback-list-table tbody tr.outerwhisper-feedback-row'));
                const currentIndex = rows.findIndex(r => r.getAttribute('data-id') === String(feedbackId));

                if (currentIndex !== -1) {
                    if (currentIndex + 1 < rows.length) {
                        nextTargetRow = rows[currentIndex + 1];
                    } else if (currentIndex - 1 >= 0) {
                        nextTargetRow = rows[currentIndex - 1];
                    }
                }

                const currentRow = document.querySelector(`tr.outerwhisper-feedback-row[data-id="${feedbackId}"]`);
                if (currentRow) {
                    currentRow.remove();
                }

                if (nextTargetRow) {
                    nextTargetId = nextTargetRow.getAttribute('data-id');
                } else {
                    if (drawer) {
                        drawer.innerHTML = `<div class="outerwhisper-feedback-drawer-empty"><p>${__('admin.page.feedback_list.table.no_items', 'outerwhisper')}</p></div>`;
                    }
                    this.currentFeedbackId = null;
                }
            } else {
                alert(result.data || __('admin.feedback.delete_error'));
            }
        } catch (error) {
            console.error('[OUTERWHISPER] Delete error:', error);
            alert(__('admin.feedback.delete_network_error'));
        } finally {
            this.isLoading = false;
            this.setDrawerLoading(drawer, false);
        }

        if (nextTargetId && nextTargetRow) {
            await this.fetchFeedbackDetails(nextTargetId, nextTargetRow);
        }
    },

    navigateDrawer: function(direction) {
        const rows = Array.from(document.querySelectorAll('.outerwhisper-feedback-list-table tbody tr.outerwhisper-feedback-row'));
        if (!rows.length) return;

        const currentIndex = rows.findIndex(r => r.getAttribute('data-id') === String(this.currentFeedbackId));
        const targetIndex = currentIndex + direction;

        if (targetIndex >= 0 && targetIndex < rows.length) {
            const targetRow = rows[targetIndex];
            const targetId = targetRow.getAttribute('data-id');
            if (targetId) {
                this.fetchFeedbackDetails(targetId, targetRow);
            }
        }
    }
};

export const initAdminFeedbackList = () => adminFeedbackList.init();
export default adminFeedbackList;
