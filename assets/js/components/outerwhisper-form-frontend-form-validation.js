import { utils, logger } from './outerwhisper-form-utils.js';

/**
 * OuterWhisper Form Targeting Validator
 * 
 * Validates form targeting rules client-side.
 * Mirrors the logic from IndexBuilder.php
 */

export const OUTERWHISPERFormValidator = {
    /**
     * Evaluates a single targeting rule.
     */
    evaluateRule: (rule, context) => {
        if (!rule || !context) {
            logger.warn('[FormValidator] evaluateRule called with missing rule or context', { rule, context });
            return false;
        }

        const { type, operator, value } = rule;
        let result = false;

        switch (type) {
            case 'page_type':
                if (operator === 'in' && Array.isArray(value)) {
                    result = value.includes(context.currentPostType);
                } else {
                    result = context.currentPostType === value;
                }
                logger.log(`[FormValidator] Evaluating page_type rule: currentPostType="${context.currentPostType}" ${operator} ${JSON.stringify(value)} => ${result}`);
                return result;

            case 'device':
                if (operator === 'in' && Array.isArray(value)) {
                    result = value.includes(context.currentDevice);
                } else {
                    result = context.currentDevice === value;
                }
                logger.log(`[FormValidator] Evaluating device rule: currentDevice="${context.currentDevice}" ${operator} ${JSON.stringify(value)} => ${result}`);
                return result;

            default:
                logger.warn(`[FormValidator] Unknown rule type "${type}"`, rule);
                return false;
        }
    },

    /**
     * Validates the full targeting structure for a form.
     */
    validateTargeting: (targeting, context) => {
        const contextValues = context ? {
            currentUrl: context.currentUrl,
            currentPostType: context.currentPostType,
            currentDevice: context.currentDevice,
            isFrontpage: context.isFrontpage,
            ...context
        } : null;
        logger.log('[FormValidator] Starting targeting validation', { targeting, context: contextValues });

        if (!targeting) {
            logger.log('[FormValidator] No targeting rules found, validation passed');
            return true;
        }

        const { singleRules, andRules, orRules } = targeting;

        // 1. Evaluate singleRules
        if (singleRules && singleRules.show_on_frontpage === false && context && context.isFrontpage) {
            logger.log('[FormValidator] Targeting failed: form is hidden on frontpage (singleRules.show_on_frontpage = false)');
            return false;
        }

        // 2. Evaluate andRules (all must be true)
        if (andRules && andRules.length > 0) {
            logger.log(`[FormValidator] Evaluating ${andRules.length} AND rule(s)...`);
            for (let i = 0; i < andRules.length; i++) {
                const rule = andRules[i];
                const match = OUTERWHISPERFormValidator.evaluateRule(rule, context);
                if (!match) {
                    logger.log(`[FormValidator] Targeting failed: AND rule #${i + 1} did not match`, rule);
                    return false;
                }
            }
        }

        // 3. Evaluate orRules (at least one must be true, if any exist)
        if (orRules && orRules.length > 0) {
            logger.log(`[FormValidator] Evaluating ${orRules.length} OR rule(s)...`);
            const anyOrMatch = orRules.some(rule => OUTERWHISPERFormValidator.evaluateRule(rule, context));
            if (!anyOrMatch) {
                logger.log('[FormValidator] Targeting failed: none of the OR rules matched', orRules);
                return false;
            }
        }

        logger.log('[FormValidator] Targeting validation passed successfully');
        return true;
    },

    isFieldInvalid: (type, val, item = null) => {
        if (type === 'name') {
            if (val === undefined || val === null) return true;
            if (typeof val === 'string') return val.trim() === '';
            if (typeof val === 'object') {
                const nameType = item?.settings?.nameType || 'full';
                if (nameType === 'first_last' || nameType === 'first_middle_last') {
                    const first = (typeof val.first === 'string' ? val.first : '').trim();
                    const last = (typeof val.last === 'string' ? val.last : '').trim();
                    return first === '' || last === '';
                }
                if (nameType === 'full') {
                    const full = (typeof val.full === 'string' ? val.full : (typeof val.first === 'string' ? val.first : '')).trim();
                    return full === '';
                }
                const hasNonEmpty = Object.values(val).some(v => typeof v === 'string' && v.trim() !== '');
                return !hasNonEmpty;
            }
            return true;
        }

        if (type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (val === undefined || val === null) return true;
            if (typeof val === 'string') {
                const trimmed = val.trim();
                return trimmed === '' || !emailRegex.test(trimmed);
            }
            if (typeof val === 'object') {
                const emailConfirmation = item?.settings?.emailConfirmation || ('confirm' in val);
                const main = (typeof val.main === 'string' ? val.main : '').trim();
                if (main === '' || !emailRegex.test(main)) return true;
                if (emailConfirmation) {
                    const confirm = (typeof val.confirm === 'string' ? val.confirm : '').trim();
                    if (confirm === '' || main.toLowerCase() !== confirm.toLowerCase()) {
                        return true;
                    }
                }
                return false;
            }
            return true;
        }

        return (val === undefined || val === null || (typeof val === 'string' && val.trim() === ''));
    }
};

export const isFieldInvalid = OUTERWHISPERFormValidator.isFieldInvalid;
