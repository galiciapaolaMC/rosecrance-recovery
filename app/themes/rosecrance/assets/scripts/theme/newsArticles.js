const initNewsArticles = () => {
    const containers = document.querySelectorAll('.news-articles');

    const DEFAULT_SHOW_COUNT = 8;
    const DEFAULT_RESULTS_COUNT = 0;

    if (containers.length >= 0) {
        const initializeModule = container => {
            const viewToggleContainer = container.querySelector('.news-articles__view-button-container');
            const viewToggle = viewToggleContainer.querySelector('.news-articles__view-toggle-button');
            console.log(viewToggle);
            const cards = container.querySelectorAll('.news-card');
            const showMoreTextContent = viewToggle.getAttribute('data-show-text');
            const showLessTextContent = viewToggle.getAttribute('data-hide-text');

            // State Variables
            let showCount = DEFAULT_SHOW_COUNT;
            let resultsCount = cards ? cards.length : DEFAULT_RESULTS_COUNT;


            const setupViewToggleClickHandler = () => {
                viewToggle.addEventListener('click', e => {
                    showCount = showCount === DEFAULT_SHOW_COUNT ? null : DEFAULT_SHOW_COUNT; 

                    render();
                });
            }

            const renderViewToggle = () => {
                if (showCount !== null) {
                    viewToggle.innerHTML = showMoreTextContent;
                } else {
                    viewToggle.innerHTML = showLessTextContent;
                }

                if (resultsCount <= showCount) {
                    viewToggleContainer.style.display = 'none';
                } else {
                    viewToggleContainer.style.display = 'block';
                }
            }
                
            const renderCards = () => {
                let renderedCardCount = 0;

                [...cards].forEach((card, index) => {
                    const cardIsAboveFold = showCount === null || renderedCardCount < showCount;
                    console.log(cardIsAboveFold);
                    if (cardIsAboveFold) {
                        renderedCardCount++;
                    }
                    card.setAttribute('data-visible', cardIsAboveFold);
                });
            }

            const render = () => {
                renderViewToggle();
                renderCards();
            }

            render();
            setupViewToggleClickHandler();
        }

        containers.forEach(container => initializeModule(container));
    }
}

export default initNewsArticles;