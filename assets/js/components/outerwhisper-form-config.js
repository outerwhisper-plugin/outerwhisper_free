/**
 * Config definitions, options, and templates for OuterWhisper FormBuilder
 */

let fieldTypesConfig = '';
let formTemplates = '';
let upgradeUrl = 'https://outerwhisper.de';
let locale = 'en_GB';
if (typeof outerwhisperFormBuilder !== "undefined") {
    fieldTypesConfig = outerwhisperFormBuilder.fieldTypesConfig || '';
    formTemplates = outerwhisperFormBuilder.formTemplates || '';
    locale = outerwhisperFormBuilder.locale || 'en_GB';
}

if (typeof outerwhisperAdmin !== "undefined") {
    locale = outerwhisperAdmin.locale || 'en_GB';
}

export const config = {
    upgradeUrl: upgradeUrl,
    locale: locale,
    localeV2: locale.replace('_', '-'),
    CONTEXT: {
        get currentUrl() { return window.location.pathname; },
        get currentPostType() { return (typeof outerwhisperFormFrontend !== "undefined" && outerwhisperFormFrontend.postType) ? outerwhisperFormFrontend.postType : ''; },
        get currentDevice() { return window.matchMedia("(max-width: 767px)").matches ? 'mobile' : 'desktop'; },
        get isFrontpage() { return !!(typeof outerwhisperFormFrontend !== "undefined" && outerwhisperFormFrontend.isFrontpage); }
    },
    FIELD_TYPES_CONFIG: fieldTypesConfig,
    FORM_TEMPLATES: formTemplates
};
