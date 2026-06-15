const initProgramsAndServicesPage = () => {
    const container = document.querySelector('.programs-and-services');

    const DEFAULT_SELECTED_CONDITIONS = [];
    const DEFAULT_SELECTED_AUDIENCE = '';
    const DEFAULT_SELECTED_REGION = '';
    const DEFAULT_SHOW_PROGRAMS = false;
    const DEFAULT_SHOW_SERVICES = false;
    const DEFAULT_SHOW_VIRTUAL = true;
    const DEFAULT_SHOW_COUNT = 16;
    const DEFAULT_RESULTS_COUNT = 0;

    const regionLocationMap = window.region_location_map || {};

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let audienceParam = urlParams.get('audience-filter');
    let conditionParam = urlParams.get('condition-filter');

    if (container) {
        // DOM nodes
        const resultsCountNode = document.querySelector('.programs-and-services__results-count');
        const viewButtonContainer = document.querySelector('.programs-and-services__view-button-container');
        const viewButton = document.querySelector('#view-more-less-button');
        const cardNodes = document.querySelectorAll('.preview-card');

        // state variables
        let cards = {};
        let selectedConditions = DEFAULT_SELECTED_CONDITIONS;
        let selectedAudience = DEFAULT_SELECTED_AUDIENCE;
        let selectedRegion = DEFAULT_SELECTED_REGION;
        let showPrograms = DEFAULT_SHOW_PROGRAMS;
        let showServices = DEFAULT_SHOW_SERVICES;
        let showVirtual = DEFAULT_SHOW_VIRTUAL;
        let showCount = DEFAULT_SHOW_COUNT;
        let resultsCount = DEFAULT_RESULTS_COUNT;

        // URL Parameters
        if (audienceParam) {
            let filterAudience = document.querySelector('input[name="audience"][data-filter-value="' + audienceParam + '"]');
            let spanFilter = document.querySelector('button[aria-controls="audience_select-field_dropdown"] span.select-field__selected-value');
            selectedAudience = filterAudience.value;
            spanFilter.innerHTML = filterAudience.getAttribute('data-label-value');
        }

        if (conditionParam) {
            let conditionArray = conditionParam.split(',');
            let spanFilter = document.querySelector('button[aria-controls="conditions_select-field_dropdown"] span.select-field__selected-value');
            spanFilter.innerHTML = '';

            conditionArray.forEach(condition => {
                let filterCondition = document.querySelector('input[name="conditions"][data-filter-value="' + condition + '"]');
                selectedConditions = [filterCondition.value];
                filterCondition.checked = true;
                spanFilter.innerHTML += filterCondition.getAttribute('data-label-value') + ', ';
            });
        }
        
        // initialize card data array
        [...cardNodes].forEach(cardNode => {
            const postId = cardNode.getAttribute('id')?.split('-')[1] || null;
            if (postId !== null) {
                const postType = cardNode.getAttribute('data-post-type');
                const relatedConditions = cardNode.getAttribute('data-related-conditions')?.split(',') || [];
                const relatedAudiences = cardNode.getAttribute('data-related-audiences')?.split(',') || [];
                const relatedRegions = cardNode.getAttribute('data-related-regions')?.split(',') || [];
                const relatedLocations = cardNode.getAttribute('data-related-locations')?.split(',') || [];
                cards[postId] = {
                    postId,
                    postType,
                    relatedConditions,
                    relatedAudiences,
                    relatedRegions,
                    relatedLocations,
                    visible: true
                };
            } else {
                console.error('card id not present');
            }
        });
        
        // get initial state from the DOM
        const setInitialState = () => {
            const selectedConditionsCheckboxes = document.querySelectorAll('input[name="conditions"]:checked');
            if (selectedConditionsCheckboxes.length > 0) {
                selectedConditions = [...selectedConditionsCheckboxes].map(el => el.value) || [];
            }
            selectedAudience = document.querySelector('input[name="audience"]:checked') || selectedAudience;
            selectedRegion = document.querySelector('input[name="region"]:checked') || selectedRegion;

            showPrograms = document.querySelector('input[name="programs"]').checked;
            showServices = document.querySelector('input[name="services"]').checked;
        }

        const getState = (member = null) => {
            const state = {
                selectedConditions,
                selectedAudience,
                selectedRegion,
                showPrograms,
                showServices,
                showVirtual,
                showCount,
                resultsCount
            }
            if (member !== null && member in state) {
                return state[member];
            }
            return state;
        }

        const checkConditionsMatch = cardConditions => {
            const conditionsSet = new Set(cardConditions);
            const commonConditions = selectedConditions.filter(condition => conditionsSet.has(condition));

            return commonConditions.length > 0;
        }

        const checkRegionMatch = locationIdArray => {
            if (selectedRegion === 'virtual' && window.virtual_location_id && locationIdArray.includes(window.virtual_location_id.toString())) {
                return true;
            }

            const regionSet = new Set(locationIdArray);
            const selectedLocations = regionLocationMap[selectedRegion] || [];
            const commonLocations = selectedLocations.filter(location => regionSet.has(location));
            return !!commonLocations.length;
        }

        const setCardVisibility = () => {
            let newResultsCount = 0;
            Object.values(cards).forEach((card, index) => {
                const hasCurrentCondition = selectedConditions === '' || selectedConditions.length === 0 || checkConditionsMatch(card.relatedConditions);
                const hasCurrentAudience = selectedAudience === '' || card.relatedAudiences.includes(selectedAudience);
                // todo, check if region has locations related to program/;service
                const hasCurrentRegion = selectedRegion === '' || checkRegionMatch(card.relatedLocations);
                
                let hasVisiblePostType = true;
                if (card.postType === 'service') {
                    hasVisiblePostType = showServices;
                } else if (card.postType === 'program') {
                    hasVisiblePostType = showPrograms;
                }
                // TODO: add check for isvirtual
                if (hasCurrentCondition && hasCurrentAudience && hasCurrentRegion && hasVisiblePostType) {
                    newResultsCount++;
                    card.visible = true;
                } else {
                    card.visible = false;
                }
            });
            resultsCount = newResultsCount;

        }

        const renderCards = () => {
            let renderedCardCount = 0;
            [...document.querySelectorAll('.preview-card')].forEach((cardNode, index) => {
                const cardIsAboveFold = showCount === null || renderedCardCount < showCount;

                const cardNodeId = cardNode.getAttribute('id')?.split('-')[1];
                if (cardNodeId in cards && cards[cardNodeId].visible && cardIsAboveFold) {
                    renderedCardCount++;
                    const cardData = cards[cardNodeId]
                    cardNode.setAttribute('data-visible', cardData.visible);
                } else {
                    cardNode.setAttribute('data-visible', false);
                }
            });
        }

        const renderResultsCount = () => {
            resultsCountNode.innerHTML = resultsCount;
        }

        const renderViewButton = () => {
            if (showCount !== null) {
                viewButton.innerHTML = viewButton.getAttribute('data-show-text');
            } else {
                viewButton.innerHTML = viewButton.getAttribute('data-hide-text');
            }

            if (resultsCount <= showCount) {
                viewButtonContainer.style.display = 'none';
            }
            else {
                viewButtonContainer.style.display = 'block';
            }
        }

        const handleSelectChange = detail => {
            const { name: fieldName, checkedValues } = detail;
            const hasCheckedValues = checkedValues !== null;

            if (!hasCheckedValues) {
                console.log('event contained no checked values', detail);
            } else if (fieldName === 'conditions') {
                selectedConditions = checkedValues.length ? checkedValues : DEFAULT_SELECTED_CONDITIONS;
            } else if (fieldName === 'audience') {
                selectedAudience = checkedValues.length ? checkedValues[0] : DEFAULT_SELECTED_AUDIENCE;
            } else if (fieldName === 'region') {
                selectedRegion = checkedValues.length ? checkedValues[0] : DEFAULT_SELECTED_REGION;
            }
        }

        const handleToggleChange = detail => {
            if (detail !== null) {
                const { value , name} = detail;
                if (name === 'services') {
                    showServices = value;
                } else if (name === 'programs') {
                    showPrograms = value;
                }
            }
        }

        const setupViewButtonHandler = () => {
            viewButton.addEventListener('click', e => {
                showCount = showCount === DEFAULT_SHOW_COUNT ? null : DEFAULT_SHOW_COUNT; 

                render();
            })
        }

        const setupEventHandlers = () => {
            document.addEventListener('fieldStateChanged', e => {
                const { detail } = e;
                const { fieldType } = detail;
                if (fieldType === 'select') {
                    handleSelectChange(detail);
                } else if (fieldType === 'toggle') {
                    handleToggleChange(detail);
                } else {
                    console.log('event did not contain field type', detail);
                }

                render();
                console.log('new state', getState());
            })
            setupViewButtonHandler();
        }

        const render = () => {
            setCardVisibility();
            renderCards();
            renderResultsCount();
            renderViewButton();
        }


        setInitialState();
        setupEventHandlers();

        render();
    }
}

export default initProgramsAndServicesPage;