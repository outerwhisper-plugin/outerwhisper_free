import { utils } from './outerwhisper-form-utils.js';
import { config } from './outerwhisper-form-config.js';

import { __ } from './outerwhisper-i18n.js';

export const FormBuilderTemplates = {
    init: function() {
        const container = document.getElementById("outerwhisper-templates-container");
        if (!container) return;

        container.innerHTML = "";

        // Render each template dynamically
        Object.entries(config.FORM_TEMPLATES).forEach(([key, tmpl]) => {
            // Create card element
            const card = document.createElement("div");
            card.className = 'outerwhisper-template-card-new';
            card.dataset.template = key;

            // Card Header
            const header = document.createElement("div");
            header.className = "outerwhisper-template-card-header";

            const title = document.createElement("h4");
            title.className = "outerwhisper-template-card-title";
            title.textContent = tmpl.title;
            header.appendChild(title);

            // Refresh Button for Resetting the Preview
            const refreshBtn = document.createElement("button");
            refreshBtn.className = "outerwhisper-template-card-refresh-btn";
            refreshBtn.type = "button";
            refreshBtn.title = __("admin.builder.reset_preview");
            refreshBtn.innerHTML = '<i class="fas fa-redo"></i>';
            header.appendChild(refreshBtn);

            card.appendChild(header);

            // Card Body (scrollable form preview area)
            const body = document.createElement("div");
            body.className = "outerwhisper-template-card-body outerwhisper-feedback-plugin";
            body.id = `outerwhisper-tmpl-preview-${key}`;
            // Mark for lazy rendering
            body.dataset.rendered = "false";
            card.appendChild(body);

            // Function to render/re-render this preview form
            const renderPreview = () => {
                if (window.OUTERWHISPERFrontend) {
                    body.outerwhisperCurrentStep = 1;
                    body.outerwhisperStep2TriggerId = null;
                    body.outerwhisperAnswers = {};

                    const tempState = {
                        settings: {
                            styles: {
                                accentColor: '#000000',
                                secondaryColor: '#555555',
                            }
                        },
                        title: tmpl.title,
                        steps: tmpl.steps,
                    };

                    window.OUTERWHISPERFrontend.render(body, tempState, {
                        isPreview: true,
                        isSplit: false,
                        onConfirm: () => {
                            console.log(`OuterWhisper: Dummy confirm on template preview ${key}`);
                        }
                    });
                }
                body.dataset.rendered = "true";
            };

            // Attach render function for lazy load & refresh button
            body.outerwhisperRenderPreview = renderPreview;

            refreshBtn.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                renderPreview();
            });

            // Card Footer
            const footer = document.createElement("div");
            footer.className = "outerwhisper-template-card-footer";

            const footerBtn = document.createElement("button");
            footerBtn.className = 'outerwhisper-template-card-btn';
            footerBtn.type = "button";
            footerBtn.innerHTML = '<i class="fas fa-plus"></i> ' + __("admin.builder.use_template");

            footer.appendChild(footerBtn);
            card.appendChild(footer);

            // Add card to grid
            container.appendChild(card);

            // Click Handler for Template Loading or PRO Upgrade (on the button, not card)
            footerBtn.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();

                const formBuilder = window.OUTERWHISPERFormBuilder;
                if (!formBuilder) return;

                if (confirm(__("admin.confirm.load_template"))) {
                    formBuilder.state.settings.main.title = tmpl.title;
                    formBuilder.state.steps = JSON.parse(JSON.stringify(tmpl.steps));

                    if (key === 'blank') formBuilder.state.activeStep2TriggerId = "";
                    else if (key === 'website') formBuilder.state.activeStep2TriggerId = "web-2";
                    else formBuilder.state.activeStep2TriggerId = "";

                    formBuilder.controller.loadFormStateToInputs();
                    formBuilder.engine.renderStepCanvas(1);
                    formBuilder.engine.renderStepCanvas(2);
                    formBuilder.controller.setStepFocus(1);

                    const modal = document.getElementById("outerwhisper-modal-templates");
                    if (modal) modal.classList.remove("outerwhisper-modal-overlay-active");

                    utils.showToast(__("admin.toast.template_loaded", { title: tmpl.title }), "success");
                    formBuilder.api.saveStateToLocalStorage();
                }
            });
        });

        // Setup IntersectionObserver for Lazy Rendering of the form templates
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                root: document.querySelector("#outerwhisper-modal-templates .outerwhisper-modal-body") || null,
                rootMargin: "50px",
                threshold: 0.01
            };

            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const bodyEl = entry.target;
                        if (bodyEl.dataset.rendered === "false") {
                            if (typeof bodyEl.outerwhisperRenderPreview === "function") {
                                bodyEl.outerwhisperRenderPreview();
                            }
                            obs.unobserve(bodyEl); // Render once, then stop observing
                        }
                    }
                });
            }, observerOptions);

            // Observe all bodies
            document.querySelectorAll(".outerwhisper-template-card-body").forEach(el => {
                observer.observe(el);
            });
        } else {
            // Fallback for browsers without IntersectionObserver (render everything immediately)
            document.querySelectorAll(".outerwhisper-template-card-body").forEach(bodyEl => {
                if (typeof bodyEl.outerwhisperRenderPreview === "function") {
                    bodyEl.outerwhisperRenderPreview();
                }
            });
        }
    }
};
