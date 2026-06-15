const initHeaderMenu = () => {
  const menuButton = document.querySelector(".mega-toggle-animated");
  const orangeMenu = document.querySelector(".header__orange-nav-mobile");
  const menuSearch = document.querySelector(".header__search-mobile");
  const menuItem = document.querySelector(".mega-menu-item-has-children");
  const backButton = document.querySelector(".header__back-button");
  const menuItemHide = document.querySelectorAll(".mega-main-link");
  const megaMenu = document.querySelector("#mega-menu-primary");
  const header = document.querySelector(".header");
  const headerSearch = document.querySelector("#search-button");
  let viewPort = window.innerWidth > 1000 ? 'desktop' : 'mobile';

  if (menuButton) {
    let windowWidth = window.innerWidth;
    
    // disable functionality that closes menu when click outside occurs
    megaMenu.setAttribute('data-document-click', 'disabled');


    const hideAndResetMenuItems = e => {
      // Hide mega sub menus that may be open
      menuItemHide.forEach(item => {
        item.classList.remove('mega-main-link--hidden');
        item.classList.remove('mega-toggle-on');
      });
      backButton.style.display = 'none';
    }

    const initMobileMenu = () => {
      menuItem.addEventListener("click", function(event) {
        if (viewPort !== 'mobile') {
          return;
        }

        let menuID = this.getAttribute("id");
        let menuClicked = document.getElementById(menuID);

        if (menuItem.classList.contains('mega-toggle-on')) {
          backButton.style.display = "block";
          
          menuItemHide.forEach(function(item) {
            if (item !== menuClicked) {
              item.classList.add('mega-main-link--hidden');
            }
          });
        } else {
          backButton.style.display = "none";
          
          menuItemHide.forEach(function(item) {
            item.classList.remove('mega-main-link--hidden');
          });
        }
      });

      backButton.addEventListener("click", function(event) {
        if (viewPort !== 'mobile') {
          return;
        }
        setTimeout(function() {          
          backButton.style.display = "none";

          menuItemHide.forEach(function(item) {
            item.classList.remove('mega-main-link--hidden');
            if (item.classList.contains('mega-toggle-on')) {
              item.classList.remove('mega-toggle-on');
            }
          });
        });
      });

      window.addEventListener('resize', function(event) {
        windowWidth = window.innerWidth;
      
        if (windowWidth > 1000 && viewPort !== 'desktop') {
          viewPort = 'desktop';
          hideAndResetMenuItems();
        }
        if (windowWidth <= 1000 && viewPort !=='mobile') {
          viewPort = 'mobile';
        }
      }, true);
    }

    const toggleMobileMenu = e => {
      const previousMenuExpansionState = menuButton.getAttribute('aria-expanded');
      if (previousMenuExpansionState !== 'false') {
        hideAndResetMenuItems();
      }
    }

    menuButton.addEventListener('click', toggleMobileMenu);

    initMobileMenu();
  }

  if (headerSearch) {
    headerSearch.addEventListener("click", function(event) {
      document.querySelector(".search-container").classList.add("search-active");
      document.querySelector(".search-form-container").style.display = "inline-block";
      this.style.display = "none";
    });
  }

};

export default initHeaderMenu;
