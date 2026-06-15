
const initMediaHero = () => {
  const heroContainer = document.querySelector(".media-hero");
  if (!heroContainer) return;

  const heroContent = heroContainer.querySelector(".media-hero__section--left");
  const heroMedia = heroContainer.querySelector(".media-hero__section--right");
  let heroContentHeight = heroContent.offsetHeight;


  if (window.innerWidth >= 960) {
    heroContentHeight = parseInt(heroContentHeight) + 170;
    heroMedia.style.minHeight = `${heroContentHeight}px`;
  }

  window.addEventListener("resize", () => {
    if (window.innerWidth >= 960) {
      heroContentHeight = parseInt(heroContent.offsetHeight) + 170;
      heroMedia.style.minHeight = `${heroContentHeight}px`;
    } else {
      heroMedia.style.minHeight = "auto";
    }
  });
};

export default initMediaHero;
