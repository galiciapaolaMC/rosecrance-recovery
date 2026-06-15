// WP localized variable post_data available to this script
const initResourceLibrary = () => {
    const container = document.querySelector('.resource-library');

    const DEFAULT_SELECTED_CONDITIONS = [];
    const DEFAULT_SELECTED_AUDIENCE = '';
    const DEFAULT_SELECTED_PROGRAMS = '';
    const DEFAULT_SELECTED_SERVICES = '';
    const DEFAULT_SHOW_PODCASTS = true;
    const DEFAULT_SHOW_VIDEOS = true;
    const DEFAULT_SHOW_BLOG_ARTICLES = true;
    const DEFAULT_SHOW_EXTENDED_ARTICLES = true;
    // const DEFAULT_SHOW_DRUG_SHEETS = true;
    const DEFAULT_SEARCH_VALUE = '';
    const DEFAULT_SHOW_COUNT = 16;
    const DEFAULT_RESULTS_COUNT = 0;

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let audienceParam = urlParams.get('audience-filter');
    let conditionsParam = urlParams.get('conditions-filter');
    let programsParam = urlParams.get('programs-filter');
    let servicesParam = urlParams.get('services-filter');
    let postsParam = urlParams.get('filter');
    const url = new URL(window.location.href);

    if (container) {
        // DOM nodes
        const resultsCountNode = document.querySelector('.resource-library__results-count');
        const viewButtonContainer =  document.querySelector('.resource-library__view-button-container');
        const viewButton = document.querySelector('#view-more-less-button');
        const cardNodes = document.querySelectorAll('[data-card-container]');
        const cardNodeMap = {};
        const textContentMap = {};

        // state variables 
        let cards = {};
        let selectedConditions = DEFAULT_SELECTED_CONDITIONS;
        let selectedAudience = DEFAULT_SELECTED_AUDIENCE;
        let selectedPrograms = DEFAULT_SELECTED_PROGRAMS;
        let selectedServices = DEFAULT_SELECTED_SERVICES;
        let showPodcasts = DEFAULT_SHOW_PODCASTS;
        let showVideos = DEFAULT_SHOW_VIDEOS;
        let showBlogArticles = DEFAULT_SHOW_BLOG_ARTICLES;
        let showExtendedArticles = DEFAULT_SHOW_EXTENDED_ARTICLES;
        // let showDrugSheets = DEFAULT_SHOW_DRUG_SHEETS;
        let searchValue = DEFAULT_SEARCH_VALUE;
        let showCount = DEFAULT_SHOW_COUNT;
        let resultsCount = DEFAULT_RESULTS_COUNT;
        let cardVisibility = {};

        // URL Parameters
        if (postsParam) {
            let filterPosts = postsParam.split(',');
            
            document.querySelectorAll('input.toggle-switch__checkbox').forEach(post => {
                post.checked = false;
            });
            
            filterPosts.forEach(post => {
                let filterPost = document.querySelector('input[name="' + post + '"]');
                
                if (postsParam) {
                    let filterPosts = postsParam.split(',');

                    document.querySelectorAll('input.toggle-switch__checkbox').forEach(post => {
                        post.checked = false;
                    });

                    filterPosts.forEach(post => {
                        let filterPost = document.querySelector('input[name="' + post + '"]');

                        if (filterPost) {
                            filterPost.checked = true;
                        }
                    });
                }
            });
        }

        if (audienceParam) {
            let filterAudience = document.querySelector('input[name="audience"][data-filter-value="' + audienceParam + '"]');
            let spanFilter = document.querySelector('button[aria-controls="audience_select-field_dropdown"] span.select-field__selected-value');
            selectedAudience = filterAudience.value;
            spanFilter.innerHTML = filterAudience.getAttribute('data-label-value');
        }

        if (programsParam) {
            selectedPrograms = programsParam;
        }

        if (servicesParam) {
            selectedServices = servicesParam;
        }

        if (conditionsParam) {
            let filterConditions = conditionsParam.split(',');
            let spanFilter = document.querySelector('button[aria-controls="conditions_select-field_dropdown"] span.select-field__selected-value');
            let conditionsValues = [];
            
            filterConditions.forEach(condition => {
                const filterCondition = document.querySelector(
                    'input[name="conditions"][data-filter-value="' + condition + '"]'
                );

                if (filterCondition) {
                    filterCondition.checked = true;
                    selectedConditions = [...selectedConditions, filterCondition.value];
                    conditionsValues = [...conditionsValues, filterCondition.getAttribute('data-label-value')];
                }
            });
            
            spanFilter.innerHTML = conditionsValues.join(', ');
        }

        [...cardNodes].forEach(cardNode => {
            const cardIdParts = cardNode.getAttribute('id').split('-');
            cardNodeMap[cardIdParts[0]] = cardNode;
        })

        
        // generate textContentMap and add visibility property
        Object.values(post_data).forEach((post) => {
            const { 
                description_text: descriptionText, 
                title_text: titleText,
                id
            } = post;
            
            post.visible = true;

            textContentMap[id] = `${titleText.toLowerCase()} ${descriptionText.toLowerCase()}`;
        });

        const getState = (member = null) => {
            const state = {
                selectedConditions,
                selectedAudience,
                showPodcasts,
                showVideos,
                showBlogArticles,
                showExtendedArticles,
                // showDrugSheets,
                searchValue,
                showCount,
                resultsCount
            }
            if (member !== null && member in state) {
                return state[member];
            }

            setPostParams(selectedConditions, selectedAudience, showPodcasts, showVideos, showBlogArticles, showExtendedArticles);

            return state;
        }

        const checkConditionsMatch = cardConditions => {
            const conditionsSet = new Set(cardConditions);
            const commonConditions = selectedConditions.filter(condition => conditionsSet.has(condition));

            return commonConditions.length > 0;
        }

        const setCardVisibility = () => {
            let newResultsCount = 0;
            Object.values(post_data).forEach(post => {
                const {
                    related_conditions: relatedConditions,
                    related_audiences: relatedAudiences,
                    related_services: relatedServices,
                    related_programs: relatedPrograms,
                    id, 
                    type
                } = post;
                const textContent = textContentMap[id];
                const hasCurrentCondition = selectedConditions === '' || selectedConditions.length === 0 || checkConditionsMatch(relatedConditions);
                const hasCurrentAudience = selectedAudience === '' || relatedAudiences.includes(selectedAudience);
                const hasCurrentProgram = selectedPrograms === '' || relatedPrograms.includes(selectedPrograms);
                const hasCurrentService = selectedServices === '' || relatedServices.includes(selectedServices);
                
                let hasVisiblePostType = true;
                if (type === 'podcast') {
                    hasVisiblePostType = showPodcasts;
                } else if (type ==='videos') {
                    hasVisiblePostType = showVideos;
                } else if (type === 'blog-post') {
                    hasVisiblePostType = showBlogArticles;
                } else if (type === 'extended-article') {
                    hasVisiblePostType = showExtendedArticles;
                }

                let matchesKeyWord = true;

                if (searchValue !== '' && textContent !== '') {
                    matchesKeyWord = textContent.includes(searchValue);
                }
                const isVisible = hasCurrentCondition && hasCurrentAudience && hasCurrentProgram && hasCurrentService && hasVisiblePostType && matchesKeyWord;
                
                if (isVisible) {
                    newResultsCount++;
                }

                cardVisibility[id] = isVisible;
            });
            resultsCount = newResultsCount;
        }

        const handleSelectChange = detail => {
            const { name: fieldName, checkedValues, slug: slugValue } = detail;
            const hasCheckedValues = checkedValues !== null;
            
            if (!hasCheckedValues) {
                console.log('event contained no checked values', detail);
            } else if (fieldName === 'conditions') {
                selectedConditions = checkedValues.length ? checkedValues : DEFAULT_SELECTED_CONDITIONS;
            } else if (fieldName === 'audience') {
                selectedAudience = checkedValues.length ? checkedValues[0] : DEFAULT_SELECTED_AUDIENCE;
            }
        }

        const handleToggleChange = detail => {
            if (detail !== null) {
                const { value , name} = detail;
                console.log(name);
                if (name === 'podcasts') {
                    showPodcasts = value;
                } else if (name === 'videos') {
                    showVideos = value;
                } else if (name === 'blog-post') {
                    showBlogArticles = value;
                } else if (name === 'extended-article') {
                    showExtendedArticles = value;
                } 
            }
        }

        const handleSearchChange = detail => {
            if (detail !== null) {
                const { value } = detail;
                searchValue = value.toLowerCase();
            }
        }

        const setupEventHandlers = () => {
            document.addEventListener('fieldStateChanged', e => {
                const { detail } = e;
                const { fieldType } = detail;
                if (fieldType === 'select') {
                    handleSelectChange(detail);
                } else if (fieldType ==='text') {
                    handleSearchChange(detail);
                } else if (fieldType === 'toggle') {
                    handleToggleChange(detail);
                } else {
                    console.log('event did not contain field type', detail);
                }
                render();
                console.log('new state', getState());
            });
            setupViewButtonHandler();
        }

        const setInitialState = () => {
            const selectedConditionsCheckboxes = document.querySelectorAll('input[name="conditions"]:checked');

            if (selectedConditionsCheckboxes.length > 0) {
                selectedConditions = [...selectedConditionsCheckboxes].map(el => el.value) || [];
            }

            const audienceInput = document.querySelector('input[name="audience"]:checked');
            const searchInput = document.querySelector('input[name="search"]');
            const podcastsInput = document.querySelector('input[name="podcasts"]');
            const videosInput = document.querySelector('input[name="videos"]');
            const blogInput = document.querySelector('input[name="blog-post"]');
            const extendedInput = document.querySelector('input[name="extended-article"]');

            selectedAudience = audienceInput ? audienceInput.value : selectedAudience;
            searchValue = searchInput ? searchInput.value : searchValue;

            showPodcasts = podcastsInput ? podcastsInput.checked : DEFAULT_SHOW_PODCASTS;
            showVideos = videosInput ? videosInput.checked : DEFAULT_SHOW_VIDEOS;
            showBlogArticles = blogInput ? blogInput.checked : DEFAULT_SHOW_BLOG_ARTICLES;
            showExtendedArticles = extendedInput ? extendedInput.checked : DEFAULT_SHOW_EXTENDED_ARTICLES;
        };

        const renderCards = () => {
            let renderedCardCount = 0;
            [...document.querySelectorAll('[data-card-container]')].forEach((cardNode, index) => {
                const cardIsAboveFold = showCount === null || renderedCardCount < showCount;

                console.log('Resource Library JS version: 2026-06-08-test');
                const cardNodeId = cardNode.getAttribute('id')?.split('-')[0];
                if (cardNodeId in cardVisibility && cardVisibility[cardNodeId] && cardIsAboveFold) {
                    renderedCardCount++;
                    cardNode.setAttribute('data-visible', cardVisibility[cardNodeId]);
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

        const setupViewButtonHandler = () => {
            viewButton.addEventListener('click', e => {
                showCount = showCount === DEFAULT_SHOW_COUNT ? null : DEFAULT_SHOW_COUNT; 

                render();
            })
        }

        const setPostParams = (selectedConditions, selectedAudience, showPodcasts, showVideos, showBlogArticles, showExtendedArticles) => {
            let postParams = [];
            let conditionsParams = [];
            let audienceParams = [];

            if (showPodcasts) {
                postParams = [...postParams, 'podcasts'];
            }
            if (showVideos) {
                postParams = [...postParams, 'videos'];
            }
            if (showBlogArticles) {
                postParams = [...postParams, 'blog-post'];
            }
            if (showExtendedArticles) {
                postParams = [...postParams, 'extended-article'];
            }
            
            if (selectedConditions) {
                selectedConditions.forEach(condition => {
                    console.log('condition', condition);
                    let filterCondition = document.querySelector('input[name="conditions"][value="' + condition + '"]');
                    conditionsParams = [...conditionsParams, filterCondition.getAttribute('data-filter-value')];
                });
            }

            if (selectedAudience) {
                let filterAudience = document.querySelector('input[name="audience"][value="' + selectedAudience + '"]');
                audienceParams = [...audienceParams, filterAudience.getAttribute('data-filter-value')];
            }

            url.searchParams.set("filter", "LIST_OF_POSTS_PLACEHOLDER");
            url.searchParams.set("conditions-filter", "LIST_OF_CONDITIONS_PLACEHOLDER");
            url.searchParams.set("audience-filter", "LIST_OF_AUDIENCE_PLACEHOLDER");

            let newUrlString = [];
            newUrlString = url
                .toString()
                .replace("LIST_OF_POSTS_PLACEHOLDER", postParams.join(","))
                .replace("LIST_OF_CONDITIONS_PLACEHOLDER", conditionsParams.join(","))
                .replace("LIST_OF_AUDIENCE_PLACEHOLDER", audienceParams.join(","));

            window.history.pushState(null, null, newUrlString);
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

export default initResourceLibrary;