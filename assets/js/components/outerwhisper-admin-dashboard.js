/**
 * Admin Dashboard Management
 */
import { __ } from './outerwhisper-i18n.js';

export const adminDashboard = {
    trendChartInstance: null,
    displayChartInstance: null,

    init: function() {
        this.initFilterBar();
        this.initTrendChart();
        this.initDisplayChart();
        this.initDistributionTabs();
    },

    initFilterBar: function() {
        const filterForm = document.getElementById('outerwhisper-dashboard-filter-form');
        if (!filterForm) {
            return;
        }

        const filterSelects = filterForm.querySelectorAll('.outerwhisper-dashboard-select');
        filterSelects.forEach(select => {
            select.addEventListener('change', () => {
                filterForm.submit();
            });
        });
    },

    initTrendChart: function() {
        const canvas = document.getElementById('outerwhisper-dashboard-trend-chart');
        if (!canvas || typeof window.Chart === 'undefined') {
            return;
        }

        let trendData = window.outerwhisperDashboard?.trendChartData;
        let labels = trendData?.labels || [];
        let feedbacks = trendData?.feedbacks || [];
        let scores = trendData?.scores || [];

        if (this.trendChartInstance) {
            this.trendChartInstance.destroy();
        }

        const ctx = canvas.getContext('2d');
        const areaGradient = ctx.createLinearGradient(0, 0, 0, 220);
        areaGradient.addColorStop(0, 'rgba(29, 111, 232, 0.22)');
        areaGradient.addColorStop(1, 'rgba(29, 111, 232, 0.01)');

        this.trendChartInstance = new window.Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: __('admin.page.dashboard.trend.feedbacks'),
                        data: feedbacks,
                        yAxisID: 'y',
                        borderColor: '#1d6fe8',
                        backgroundColor: areaGradient,
                        borderWidth: 2,
                        pointBackgroundColor: '#1d6fe8',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 1.5,
                        pointRadius: 3.5,
                        pointHoverRadius: 5,
                        fill: true,
                        tension: 0.2
                    },
                    {
                        label: __('admin.page.dashboard.trend.average_score'),
                        data: scores,
                        yAxisID: 'y1',
                        borderColor: '#16a34a',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        pointBackgroundColor: '#16a34a',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 1.5,
                        pointRadius: 3.5,
                        pointHoverRadius: 5,
                        fill: false,
                        tension: 0.2,
                        spanGaps: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 10,
                        cornerRadius: 6,
                        callbacks: {
                            label: function(context) {
                                if (context.dataset.yAxisID === 'y1') {
                                    return context.parsed.y !== null ? `${__('admin.page.dashboard.trend.score')}: ${context.parsed.y} / 100` : `${__('admin.page.dashboard.trend.score')}: -`;
                                }
                                return `${__('admin.page.dashboard.trend.feedbacks')}: ${context.parsed.y}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            color: '#e2e8f0'
                        },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 12,
                            maxRotation: 0,
                            color: '#475569',
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        type: 'linear',
                        position: 'left',
                        min: 0,
                        suggestedMax: 10,
                        border: {
                            display: false
                        },
                        grid: {
                            color: '#eef2f6'
                        },
                        ticks: {
                            precision: 0,
                            color: '#475569',
                            font: {
                                size: 11
                            }
                        },
                        title: {
                            display: true,
                            text: __('admin.page.dashboard.trend.feedbacks'),
                            color: '#475569',
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        position: 'right',
                        min: 0,
                        max: 100,
                        border: {
                            display: false
                        },
                        grid: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            stepSize: 20,
                            color: '#475569',
                            font: {
                                size: 11
                            }
                        },
                        title: {
                            display: true,
                            text: __('admin.page.dashboard.trend.score'),
                            color: '#475569',
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        }
                    }
                }
            }
        });
    },

    initDisplayChart: function() {
        const canvas = document.getElementById('outerwhisper-dashboard-display-chart');
        if (!canvas || typeof window.Chart === 'undefined') {
            return;
        }

        const displayStats = window.outerwhisperDashboard?.displayStats;
        let labels = displayStats?.chart_labels || [];
        let data = displayStats?.chart_data || [];
        let colors = displayStats?.chart_colors || [];

        if (this.displayChartInstance) {
            this.displayChartInstance.destroy();
        }

        const ctx = canvas.getContext('2d');
        this.displayChartInstance = new window.Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [
                    {
                        data: data,
                        backgroundColor: colors.length > 0 ? colors : ['#1d6fe8', '#0ea5a3', '#84cc16', '#f59e0b', '#94a3b8'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 8,
                        cornerRadius: 6,
                        callbacks: {
                            label: (context) => `${context.label}: ${context.parsed} %`
                        }
                    }
                }
            }
        });
    },

    initDistributionTabs: function() {
        const tabButtons = Array.from(document.querySelectorAll('.outerwhisper-dashboard-tab-btn'));
        const totalMeta = document.getElementById('outerwhisper-dashboard-dist-total');
        if (tabButtons.length === 0) {
            return;
        }

        const activateTab = (button) => {
            const targetKey = button.getAttribute('data-tab-target');
            const totalLabel = button.getAttribute('data-total-label');

            tabButtons.forEach((btn) => {
                const isActive = btn === button;
                btn.classList.toggle('is-active', isActive);
                btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });

            document.querySelectorAll('.outerwhisper-dashboard-tabpanel').forEach((panel) => {
                const matches = panel.id === `outerwhisper-dashboard-panel-${targetKey}`;
                panel.classList.toggle('hidden', !matches);
            });

            if (totalMeta && totalLabel) {
                totalMeta.textContent = totalLabel;
            }
        };

        tabButtons.forEach((btn, idx) => {
            btn.addEventListener('click', () => activateTab(btn));
            btn.addEventListener('keydown', (event) => {
                if (event.key !== 'ArrowRight' && event.key !== 'ArrowLeft') {
                    return;
                }
                event.preventDefault();
                const offset = event.key === 'ArrowRight' ? 1 : -1;
                const nextBtn = tabButtons[(idx + offset + tabButtons.length) % tabButtons.length];
                nextBtn.focus();
                activateTab(nextBtn);
            });
        });
    }
};

export const initDashboard = () => {
    adminDashboard.init();
};
