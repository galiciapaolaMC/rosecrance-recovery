const fireFieldChangeEvent = e => {
    const { target } = e;
    const { name } = target;

    const fieldType = target.getAttribute('data-field-type');
    const checked = target.checked;
    const onFieldChange = new CustomEvent('fieldStateChanged', { detail: {
        name,
        value: checked,
        fieldType
    }});

    document.dispatchEvent(onFieldChange);
}

const fireTextFieldChangeEvent = e => {
    const { target } = e;

    const { name, value } = target;

    const fieldType = target.getAttribute('data-field-type');

    const onFieldChange = new CustomEvent('fieldStateChanged', { detail: {
        name,
        value,
        fieldType
    }});
    document.dispatchEvent(onFieldChange);
}

const fireSelectFieldChangeEvent = (fieldName, selectValue, checkedValues, slug) => {
    const onFieldChange = new CustomEvent('fieldStateChanged', { detail: {
        name: fieldName,
        fieldType: 'select',
        value: selectValue,
        checkedValues,
        slug
    }});
    document.dispatchEvent(onFieldChange);
}

const initToggles = () => {
    const toggleFields = document.querySelectorAll('[data-field-type="toggle"]')

    toggleFields.forEach(toggleField => {
        toggleField.addEventListener('change', fireFieldChangeEvent);
    })
}

const initTextFields = () => {
    const textFields = document.querySelectorAll('[data-field-type="text"]');

    textFields.forEach(textField => textField.addEventListener('keyup', fireTextFieldChangeEvent));
}

const initSelectFields = () => {
    const selectFields = document.querySelectorAll('.select-field');

    document.addEventListener('click', e => {
        const activeSelects = document.querySelectorAll('.select-field--active');
        let clickInside = false;
        selectFields.forEach(selectField => {
            if (selectField.contains(e.target)) {
                clickInside = true;
            } 
        });

        if (!clickInside) {
            activeSelects.forEach(activeSelect => {
                activeSelect.classList.remove('select-field--active');
            })
        }
    })

    const setMultiSelectValue = (isChecked, label, currentValue) => {
        
        if (isChecked) {
            // add item to value
            if (currentValue === '-') {
                return label;
            }
            const newVal = currentValue.split(',')
            newVal.push(label);
            return newVal.join(', ');
        } else {
            const newVal = currentValue.split(',')
                .filter(val => val.trim() !== label)
                .join(',');
            return newVal.length < 1 ? '-' : newVal;
        }
    }

    selectFields.forEach(selectField => {
        const isMultiSelect = selectField.hasAttribute('data-multiselect');
        const button = selectField.querySelector('button');
        const selectedValue = selectField.querySelector('.select-field__selected-value');
        const checkboxes = selectField.querySelectorAll('.select-field-option__input');
        const fieldName = button.getAttribute('data-name');
        let slug = [];

        const getSelectFieldText = () => {
            const allCheckedBoxes = [...selectField.querySelectorAll('input:checked')];
            if (allCheckedBoxes.length > 0) {
                return allCheckedBoxes.reduce((accumulator, currentInput) => {
                    if (accumulator === '') {
                        return accumulator += currentInput.getAttribute('data-label-value');
                    }
                    return accumulator += ', ' + currentInput.getAttribute('data-label-value');
                }, '');
            }
            return checkboxes[0]?.getAttribute('data-label-value') || '-';
        }

        const getCurrentValues = () => {
            return [...selectField.querySelectorAll('input:checked')].map(input => input.getAttribute('value'));
        }

        const toggleActive = () => {
            selectField.classList.toggle('select-field--active');

            button.setAttribute(
                "aria-expanded",
                button.getAttribute("aria-expanded") === "true" ? "false" : "true"
            );
        }

        button.addEventListener('click', e => {
            // close all other dropdowns
            document.querySelectorAll('.select-field--active').forEach(activeDropDown => {
                if (activeDropDown !== selectField) {
                    activeDropDown.classList.remove('select-field--active');
                }
            });
            toggleActive();
        });

        selectField.addEventListener('keyup', e => {
            if (e.key === 'Escape') {
                toggleActive();
            }
        });

        document.addEventListener('fieldStateReset', e => {
            const { fieldNames } = e.detail;
            if (fieldNames.includes(fieldName)) {
                slug = [];
                if (checkboxes.length > 0) {
                    const defaultValue = checkboxes[0]?.getAttribute('data-label-value') || '-';
                    selectedValue.innerHTML = defaultValue;
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                }
            }
        });


        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', e => {
                const fieldName = checkbox.getAttribute('name');
                const label = checkbox.getAttribute('data-label-value');
                const isChecked = e.target.checked;
                const currentValue = selectedValue.innerHTML;
                const values = getCurrentValues();
                
                if (isMultiSelect) {
                    selectedValue.innerHTML = setMultiSelectValue(isChecked, label, currentValue);
                    let lowerCaseString = selectedValue.innerHTML.split(', ');

                    if (isChecked) {
                        slug.push(checkbox.getAttribute('data-filter-value'));
                    } else {
                        slug = slug.filter(item => item !== checkbox.getAttribute('data-filter-value'));
                    }
                } else {
                    slug = checkbox.getAttribute('data-filter-value');
                    selectedValue.innerHTML = label
                    toggleActive();
                }

                fireSelectFieldChangeEvent(fieldName, selectedValue.innerHTML, values, slug);
            });
        });

        // initialize values
        selectedValue.innerHTML = getSelectFieldText();
    })
}

const initFields = () => {
  initSelectFields();
  initToggles();
  initTextFields();
}

export default initFields;