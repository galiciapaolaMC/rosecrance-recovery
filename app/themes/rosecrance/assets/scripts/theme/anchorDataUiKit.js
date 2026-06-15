import UIkit from 'uikit/dist/js/uikit-core';

const initanchorDataUiKit = () => {
  const subNav = document.querySelector(".sub-navigation-wrapper");
  const modules = document.querySelectorAll(".scroll-module");
  let windowWidth = window.innerWidth;
  let displayedSlideIndex = 0;
  let viewport = null;

  if (subNav) {
    const slider = UIkit.slider('.slider-wrapper');
    const stickyNav = UIkit.sticky('.sub-navigation');

    if (windowWidth < 1000) {
      stickyNav.offset = '84';
      slider.center = true;
      viewport = 'mobile';
    } else {
      slider.center = false;
      viewport = 'desktop';
    }

    modules.forEach((module, index) => {
      let anchorID = module.getAttribute('anchor-id');
      let anchorName = module.getAttribute('anchor-name');

      if (anchorID && anchorName) {
        subNav.innerHTML += `<li>
          <button class="sub-navigation__button" data-slide-index="${index}" data-id="${anchorID}">${anchorName}</button>
        </li>`;
      }

      document.querySelectorAll('.sub-navigation__button').forEach(anchor => {
          anchor.addEventListener('click', function (e) {
              e.preventDefault();

              let anchorScroll = anchor.getAttribute('data-id');
              let element = document.querySelector('.scroll-module[anchor-id="' + anchorScroll + '"]');
              let headerOffset = 200;

              if (windowWidth < 1000) {
                headerOffset = 120;
              }

              let elementPosition = element.getBoundingClientRect().top;
              let offsetPosition = elementPosition + window.pageYOffset - headerOffset;
            
              window.scrollTo({
                  top: offsetPosition,
                  behavior: "smooth"
              });
          });
      });
    });

    window.addEventListener('scroll', function() {
      modules.forEach((module) => {
        let anchorID = module.getAttribute('anchor-id');

        if (anchorID) {
          let scrollDistance = window.scrollY;
          
          if (module.offsetTop - 650 <= scrollDistance) {
            document.querySelectorAll('.sub-navigation__button').forEach(menuItem => {
              menuItem.classList.remove('active');
            });
            const subNavButton = subNav.querySelector('.sub-navigation__button[data-id="' + anchorID + '"]');
            displayedSlideIndex = parseInt(subNavButton.dataset['slideIndex'], 10);
            subNavButton.classList.add('active');
          }
        }
      });
      if (windowWidth < 1000) {
        slider.show(displayedSlideIndex);
      }
    });

    window.addEventListener('resize', function() {
      windowWidth = window.innerWidth;
      if (windowWidth < 1000 && viewport !== 'mobile') {
        viewport = 'mobile';
        slider.center = true;
        slider.show(displayedSlideIndex);
        stickyNav.offset = '84';
      } else if (windowWidth >= 1000 && viewport !== 'desktop') {
        viewport = 'desktop';
        slider.center = false;
        stickyNav.offset = '150';
      }
    })
  }
};

export default initanchorDataUiKit;
