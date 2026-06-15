import { getInsuranceSubmitEvent, getZipCodeSubmitEvent } from './customEvents';
import { getVisitLogCookie } from './visitLog';

const initActiveTreatmentLocator = () => {
  const form = document.querySelector('.treatment-locator__form form');
  const searchButton = document.querySelector('.treatment-locator__submit');
  const zipcodeInput = document.querySelector('input[name="zip-code"]');
  const regionInput = document.querySelector('input[name="region"]');
  const tooltipTrigger = document.querySelector('.treatment-locator__additional-information-text');
  const tooltip = document.querySelector('.treatment-locator__additional-information-tooltip');
  const tooltipClose = document.querySelector('[data-tooltip-close-btn]');
  const cookie = getVisitLogCookie();
  const insuranceType = cookie?.insuranceType ?? '';
  const insuranceTypeRadio = document.querySelector(`input[name="insurance-provider"][data-label-value="${insuranceType}"]`);
  const regionContainer = document.querySelector('.treatment-locator__region-container');
  const zipcodeContainer = document.querySelector('.treatment-locator__zip-code-container');
  const locationModeCheckBox = document.querySelector('[name="location-mode-toggle"]');
  const locationModeHiddenField = document.querySelector('[name="location-mode"]');

  let locationMode = 'zip-code';
  const zipCode = cookie?.zipCode ?? '';

  const setFieldValue = (name, value) => {
    const associatedButton = document.querySelector(`button[aria-controls="${name}_select-field_dropdown"]`);
    let field;
    // if ID is passed
    if (!isNaN(value)) {
      field = document.querySelector(`input[name="${name}"][value="${value}"]`);
    // if slug is passed
    } else {
      field = document.querySelector(`input[name="${name}"][data-filter-value="${value}"]`);
    }
    if (field) {
      field.checked = true;
      const event = new Event('change');
      field.dispatchEvent(event);

      // Prevent dropdown from staying open on page load
      associatedButton.click();
    }
  }

  const initZipCodeMode = () => {
    zipcodeContainer.style.display = 'block';
    regionContainer.style.display = 'none';
    setFieldValue('regions', '');
  }

  const initRegionMode = () => {
    zipcodeContainer.style.display = 'none';
    regionContainer.style.display = 'block';
    zipcodeInput.value = '';
  }

  const init = () => {
    if (locationModeCheckBox) {
      if (locationModeCheckBox.checked) {
        locationMode = 'region';
        locationModeHiddenField.value = 'region';
        initRegionMode();
      } else {
        locationMode = 'zip-code';
        locationModeHiddenField.value = 'zip-code';
        initZipCodeMode();
      }
    }

    // listen for form submission
    if (searchButton) {
      if (cookie && zipCode) {
        zipcodeInput.value = zipCode;
      }
      if (cookie && insuranceType && insuranceTypeRadio) {
        insuranceTypeRadio.checked = true;
      }

      searchButton.addEventListener('click', e => {
        const insuranceType = document.querySelector('input[name="insurance-provider"]:checked');
        const zipCode = document.querySelector('input[name="zip-code"]');

        if (insuranceType) {
          const event = getInsuranceSubmitEvent(insuranceType.value, insuranceType.getAttribute('data-label-value'));

          document.dispatchEvent(event);
        }

        if (zipCode && locationMode === 'zip-code') {
          const event = getZipCodeSubmitEvent(zipCode.value);

          document.dispatchEvent(event);
        }

        // actual event
        const insuranceField = document.querySelector('input[name="insurance-provider"]:checked') || '';
        const postIdField = document.querySelector('input[name="post-id"]');
        const postType = postIdField?.getAttribute('data-post-type');
        const postId = postIdField?.value;
        let insuranceFieldValue = '';
        let postTypeValue = '';
        if (insuranceField && insuranceField.value) {
          insuranceFieldValue = `insurance=${insuranceField.value}&`;
        }
        if (postType && postId) {
          postTypeValue = `&${postType}=${postId}`;
        }
        if (locationMode === 'region') {
          const regionField = document.querySelector('input[name="regions"]:checked');
          window.location.href = `/locations/?${insuranceFieldValue}region=${regionField.value}${postTypeValue}&location-mode=region`;
        } else if (locationMode === 'zip-code') {
          const zipCodefield = document.querySelector('input[name="zip-code"]');
          window.location.href = `/locations/?${insuranceFieldValue}zip-code=${zipCodefield.value?.trim()}${postTypeValue}&location-mode=zip-code`;
        }
      })
    }

    if (locationModeCheckBox) {
      locationModeCheckBox.addEventListener('change', (e) => {
        const { target } = e;
        const { checked } = target;

        if (checked) {
          locationMode = 'region';
          locationModeHiddenField.value = 'region';
          initRegionMode();
        } else {
          locationMode = 'zip-code';
          locationModeHiddenField.value = 'zip-code';
          initZipCodeMode();
        }
        
      });
    }

    if (tooltip)  {
      tooltipTrigger.addEventListener('mouseover', e => {
        tooltip.classList.add('treatment-locator__additional-information-tooltip--active');
      });

      tooltipTrigger.addEventListener('mouseleave', e => {
        tooltip.classList.remove('treatment-locator__additional-information-tooltip--active');
      });

      tooltipTrigger.addEventListener('click', e => {
        tooltip.classList.add('treatment-locator__additional-information-tooltip--active');
      });

      if (tooltipClose) {
        tooltipClose.addEventListener('click', e => {
          e.preventDefault();
          const target = document.body;
          const event = new MouseEvent('click', {
            bubbles: true,
            cancelable: true,
            view: window
          });
    
          target.dispatchEvent(event);
        })
      }
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    init();
  });
}

export default initActiveTreatmentLocator;