import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollSmoother } from "gsap/ScrollSmoother";
import UIkit from 'uikit/dist/js/uikit-core';

const initAnchorData = () => {
  const subNav = document.querySelector(".sub-navigation-wrapper");
  const subNavToClone = document.querySelector(".module.sub-navigation");
  const allModules = document.querySelectorAll(".module:not(.sub-navigation)");
  const modules = document.querySelectorAll(".scroll-module");
  const header = document.querySelector(".header");
  const primaryContainer = document.querySelector("#primary");
  const smoothScroll = document.querySelector("#smooth-wrapper");
  const imageParallax = document.querySelectorAll(".image-fifty-fifty__image-holder img");
  let appendNav = 0;

  if (subNav) {
    gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

    ScrollTrigger.normalizeScroll(true)

    let smoother = ScrollSmoother.create({
      smooth: 2,
      effects: true,
      normalizeScroll: true
    });

    primaryContainer.style.height = "120%";
    smoothScroll.style.paddingTop = "140px";

    modules.forEach(module => {
      let anchorID = module.getAttribute('anchor-id');
      let anchorName = module.getAttribute('anchor-name');

      subNav.innerHTML += `<li>
        <button class="sub-navigation__button" data-id="${anchorID}">${anchorName}</button>
      </li>`;
    });

    allModules.forEach(module => {
      let moduleID = module.getAttribute('id');
      let anchorID = module.getAttribute('anchor-id');
      let parallax = module.getAttribute('uk-parallax');

      if (!parallax) {
        ScrollTrigger.create({
          trigger: "section#" + moduleID,
          pin: true,
          start: "center center",
          end: "+=300",
          onUpdate: (self) => {
            let status = self.progress;

            if (status > 0) {
              if (anchorID) {
                activateButton(anchorID, status);
              }
            }
          }
        });
      } else {
        let parallaxStart = module.getAttribute('parallax-start');
        let parallaxEnd = module.getAttribute('parallax-end');
        let parallaxText = document.querySelectorAll("section#" + moduleID + " .text-parallax");

        parallaxText.forEach(text => {
          text.style.color = parallaxEnd;
        });

        ScrollTrigger.create({
          trigger: "section#" + moduleID,
          pin: true,
          start: "-100 center",
          end: "+=300",
          onEnter: () => {
            gsap.to( "section#" + moduleID, { duration: 2, backgroundColor: parallaxEnd});
            
            parallaxText.forEach(text => {
              text.style.color = parallaxStart;
            });
          },
          onLeaveBack: () => {
            gsap.to("section#" + moduleID, { duration: 2, backgroundColor: parallaxStart});
            
            parallaxText.forEach(text => {
              text.style.color = parallaxEnd;
            });
          },
          onUpdate: (self) => {
            let status = self.progress;

            if (status > 0) {
              if (anchorID) {
                activateButton(anchorID, status);
              }
            }
          }
        });
      }
    });

    window.addEventListener("scroll", function() {
      let subNavScroll = subNav.getBoundingClientRect().top;
      let rect = subNav.getBoundingClientRect();
      let elemTop = rect.top;
      let elemBottom = rect.bottom;
      let windowWidth = window.innerWidth;
      
      if (windowWidth < 1000) {
        elemBottom = (elemBottom - 180) / 1.5;
      } 

      let notVisible = (elemTop < 140) && (elemBottom <= window.innerHeight);
      
      if (notVisible === true) {
        if (appendNav === 0) {
          let divClone = subNavToClone.cloneNode(true);
          divClone.classList.add("subnav-fixed");
          divClone.querySelector('.slider-wrapper').removeAttribute('uk-slider');
          primaryContainer.appendChild(divClone);
          appendNav++;

          setTimeout(() => {
            let buttonScroll = document.querySelectorAll(".subnav-fixed .sub-navigation__button");
            UIkit.slider('.subnav-fixed .slider-wrapper', {auto: true});

            buttonScroll.forEach(button => {
              button.addEventListener("click", function() {
                let anchorID = button.getAttribute('data-id');
                let anchor = document.querySelector('[anchor-id="' + anchorID + '"]');
                let windowWidth = window.innerWidth;
                let yOffset = -260;
                
                if (windowWidth < 1000) {
                  yOffset = -150;
                } 
      
                const position = anchor.getBoundingClientRect().top + window.pageYOffset + yOffset;
                smoother.scrollTo(anchor, true, "top 180px");
                
              });
            });
          }, 1000);

          modules.forEach(module => {
            let anchorID = module.getAttribute('anchor-id');
            let moduleScroll = module.getBoundingClientRect().top;
    
            let rect = module.getBoundingClientRect();
            let elemTop = rect.top;
            let elemBottom = rect.bottom;
            let postion = -200;
            let windowWidth = window.innerWidth;
            
            if (windowWidth < 1000) {
              postion = 180;
              elemBottom = (elemBottom - 180) / 1.5;
            } 
    
            let isVisible = (elemTop >= 140) && (elemBottom <= window.innerHeight);
            let buttonScroll = document.querySelectorAll(".subnav-fixed .sub-navigation__button");
            let anchorButton = document.querySelector('[data-id="' + anchorID + '"]');
            
            if (isVisible === true) {
              buttonScroll.forEach(button => {
                if (button.classList.contains("active")) {
                  button.classList.remove("active");
                }
              });
    
              anchorButton.classList.add("active");
            }
          });
        }
      } else {
        if (appendNav === 1) {
          document.querySelector(".subnav-fixed").remove();
          appendNav = 0;
          return;
        }
      }

      if (window.scrollY === 0){
        document.querySelector(".subnav-fixed").remove();
        appendNav = 0;
        return;
      }
    });

    setTimeout(() => {
      let buttonScroll = document.querySelectorAll(".sub-navigation__button:not(.subnav-fixed)");

      buttonScroll.forEach(button => {
        button.addEventListener("click", function() {
          let anchorID = button.getAttribute('data-id');
          let anchor = document.querySelector('[anchor-id="' + anchorID + '"]');
          let windowWidth = window.innerWidth;
          let yOffset = -260;
          
          if (windowWidth < 1000) {
            yOffset = -150;
          } 

          const position = anchor.getBoundingClientRect().top + window.pageYOffset + yOffset;
          smoother.scrollTo(anchor, true, "top 180px");
          
        });
      });
    }, 1000);

    function activateButton(anchorID, isActive) {
      let buttonsScroll = document.querySelectorAll(".sub-navigation__button");
      let anchorButton = document.querySelector('.subnav-fixed .sub-navigation__button[data-id="' + anchorID + '"]');
      
      buttonsScroll.forEach(button => {
        button.classList.remove("active");
      });
      
      if (anchorButton) {
        anchorButton.classList.add("active");
      }
    }

    if (imageParallax) {
      imageParallax.forEach(image => {
        let parallax = image.getAttribute('uk-parallax');
        let mobileId = image.getAttribute('id-mobile');
        let desktopId = image.getAttribute('id-desktop');
        let imageDesktop = document.querySelector(".image-desktop[id-desktop='"+ desktopId +"']");
        let sectionDesktop = image.closest("[id-desktop='"+ desktopId +"']");
        let imageMobile = document.querySelector(".image-mobile[id-desktop='"+ desktopId +"']");
        let sectionMobile = image.closest("[id-mobile='"+ desktopId +"']");
        let windowWidth = window.innerWidth;
        let start = 500;
        let end = 200;

        if (parallax && desktopId) {
          gsap.fromTo(
            sectionDesktop,
            {
              y: start - end
            },
            {
              y: 0,
              ease: "none",
              scrollTrigger: {
                trigger: imageDesktop,
                scrub: true
              }
            }
          );
        }

        if (parallax && mobileId) {
          gsap.fromTo(
            sectionMobile,
            {
              y: start - end
            },
            {
              y: 0,
              ease: "none",
              scrollTrigger: {
                trigger: imageMobile,
                scrub: true
              }
            }
          );
        }
      });
    }
  }
};

export default initAnchorData;
