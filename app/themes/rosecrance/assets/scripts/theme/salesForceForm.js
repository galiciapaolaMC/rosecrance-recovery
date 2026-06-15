/*
 What Needs to be done yet
    1. update Javascript below to initialize the referral form group
    2. update Javascript to listen for form referral swap input
    3. Double check that all forms have correct fields and that hidden fields are included correctly   
    4. Double check that hidden fields are being populated correctly
*/

import { getVisitLogCookie } from './visitLog';

const initSalesForceForms = () => {
    const forms = document.querySelectorAll('.salesforce-form');
    const formGroups = document.querySelectorAll('[data-form-group]');
    const initReferralForm = formGroupElement => {
        const referralSwapInput = formGroupElement.querySelector('[data-referral-swap]');
        const referralForms = formGroupElement.querySelectorAll('.salesforce-referral-form');

        const showAndHideReferralForms = () => {
            [...referralForms].forEach(form => {
                form.classList.add('salesforce-form--hidden');
            });

            const selectedForm = [...referralForms].find(form => form.getAttribute('data-form-type') === referralSwapInput.value);
            selectedForm?.classList.remove('salesforce-form--hidden');
        }

        if (referralSwapInput) {
            referralSwapInput.addEventListener('change', () => {
                showAndHideReferralForms();
            });
        }

        showAndHideReferralForms();
    }

    const hiddenFieldForms = [
        'self-referral-form',
        'self-referral-form-existing',
        'alumni-form',
        'friend-family-referral-form',
        'professional-referral-form',
    ];

    const setHiddenFieldValue = (field, cookieValue) => {
        if (field && cookieValue && Array.isArray(cookieValue)) {
            field.value = cookieValue.join(';');
        }
    }

    const initializeForm = formElement => {
        const cookie = getVisitLogCookie();

        const { 
            conditionsViewed,
            programsViewed,
            servicesViewed,
            resourcesViewed,
            locationsViewed,
            staffViewed,
            zipCode,
            insuranceType,
            pageQueue
        } = cookie;


        const conditionsViewedInput = formElement.querySelector('#conditions_viewed');
        const programsViewedInput = formElement.querySelector('#programs_viewed');
        const sevicesViewedInput = formElement.querySelector('#services_viewed');
        const resourcesViewedInput = formElement.querySelector('#resources_viewed');
        const locationsViewedInput = formElement.querySelector('#locations_viewed');
        const therapistsViewedInput = formElement.querySelector('#therapists_viewed');
        const zipCodeInput = formElement.querySelector('#zip_code');
        const insuranceTypeInput = formElement.querySelector('[name="00NVt000000o5oLMAQ"]');
        const priorPageViewedInput = formElement.querySelector('#pageview_prior');
        const currentPageViewedInput = formElement.querySelector('#form_submission_page_c');

        setHiddenFieldValue(conditionsViewedInput, conditionsViewed);
        setHiddenFieldValue(programsViewedInput, programsViewed);
        setHiddenFieldValue(sevicesViewedInput, servicesViewed);
        setHiddenFieldValue(resourcesViewedInput, resourcesViewed);
        setHiddenFieldValue(locationsViewedInput, locationsViewed);
        setHiddenFieldValue(therapistsViewedInput, staffViewed);

        if (currentPageViewedInput) {
            currentPageViewedInput.value = window.location.href;
        }

        if (priorPageViewedInput && pageQueue && pageQueue.length > 1) {
            priorPageViewedInput.value = pageQueue[pageQueue.length - 1];
        }

        if (zipCode) {
            zipCodeInput.value = zipCode;
        }

        if (insuranceType) {
            insuranceTypeInput.value = insuranceType;
        }
        console.log('initializing form', formElement);
    }
    
    const addErrorMessage = (field, message) => {
        // check if .form-error-message already exists and remove it if it does
        if (field.parentElement.querySelector('.form-error-message')) {
            removeErrorMessage(field);
        }

        const errorMessage = document.createElement('span');
        errorMessage.classList.add('form-error-message');
        errorMessage.textContent = message;
        field.parentElement.appendChild(errorMessage);
    }

    const removeErrorMessage = field => {
        const errorMessage = field.parentElement.querySelector('.form-error-message');
        errorMessage?.remove();
    }

    const initializeValidaiton = formElement => {
        const emailInputs = formElement.querySelectorAll('input[type="email"]');
        const phoneInputs = formElement.querySelectorAll('input[type="tel"]');
        const requiredInputs = formElement.querySelectorAll('input[required], select[required], textarea[required]');
        phoneInputs.forEach(phoneInput => {
            phoneInput.addEventListener('input', phoneNumberValidation);
        });
        formElement.addEventListener('submit', e => {
            e.preventDefault();
            let finalValidation = true;

            requiredInputs.forEach(requiredInput => {
                // if field is an email field, return early
                if (requiredInput.type !== 'email' && requiredInput.type !== 'tel') {
                    const result = requiredFieldValidation(requiredInput);
                    if (!result) {
                        finalValidation = false;
                    }
                }
            });

            phoneInputs.forEach(phoneInput => {
                const result = phoneNumberSubmitValidation(phoneInput);
                if (!result) {
                    finalValidation = false;
                }
            });
            
            emailInputs.forEach(emailInput => {
                const result = emailValidation(emailInput);
                if (!result) {
                    finalValidation = false;
                }
            });
            if (finalValidation) {
                formElement.submit();
            }
        });
    }

    const phoneNumberValidation = e => {
        let value = e.target.value.replace(/\D/g, ''); // Remove all non-digit characters
        let formattedValue = '';
        if (value.length > 0) {
            formattedValue += value.substring(0, 3); // First three digits
        }
        if (value.length > 3) {
            formattedValue += '-' + value.substring(3, 6); // Next three digits
        }
        if (value.length > 6) {
            formattedValue += '-' + value.substring(6, 10); // Last four digits
        }
        console.log(e.target.value, formattedValue);
        e.target.value = formattedValue;
    }

    const phoneNumberSubmitValidation = field => {
        const phoneNumber = field.value.trim();
        const phonePattern = /^\d{3}-\d{3}-\d{4}$/;
        const errorMessage = window?.validationErrors?.invalidPhone ?? 'This field is required';

        if (!phonePattern.test(phoneNumber)) {
            addErrorMessage(field, errorMessage);
            return false;
        } else {
            removeErrorMessage(field);
            return true;
        }
    }

    const requiredFieldValidation = field => {
        const errorMessage = window?.validationErrors?.requiredField ?? 'This field is required';
        if (!field.value || field.value.trim() === ''){
            addErrorMessage(field, errorMessage);
            return false;
        } else {
            removeErrorMessage(field);
            return true;
        }
    }

    const emailValidation = emailInput => {
        // stub
        // todo next
        console.log(emailInput.value);
        const email = emailInput.value?.trim();
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        const errorMessage = window?.validationErrors?.invalidEmail ?? 'Please enter a valid email address';
        if (!emailPattern.test(email)) {
            addErrorMessage(emailInput, errorMessage);
            return false;
        } else {
            removeErrorMessage(emailInput);
            return true;
        }
    }


    [...formGroups].forEach(formGroup => {
        initReferralForm(formGroup);
    });

    [...forms].forEach(form => {
        console.log(form);
        const formType = form.getAttribute('data-form-type');
        initializeValidaiton(form);

        if (hiddenFieldForms.includes(formType)) {
            initializeForm(form);
        }
    });
}

export default initSalesForceForms;