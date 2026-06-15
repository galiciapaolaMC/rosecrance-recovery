import UIkit from './UIkit';

const initSliderButtons = () => {
  const playButton = document.querySelector(".slider-play");
  const pauseButton = document.querySelector(".slider-pause");
  
  if (playButton) {
    pauseButton.addEventListener("click", function(event) {
      UIkit.slideshow(".uk-slideshow").stopAutoplay();
      pauseButton.style.display = "none";
      playButton.style.display = "inline-block";
    });

    playButton.addEventListener("click", function(event) {
      UIkit.slideshow(".uk-slideshow").startAutoplay();
      playButton.style.display = "none";
      pauseButton.style.display = "inline-block";
    });
  }
};

export default initSliderButtons;
