const initBackgroundColorChange = () => {
  const orangeContainer = document.querySelectorAll(".parallax-active.background-primary-orange");
  const blueContainer = document.querySelectorAll(".parallax-active.background-primary-blue");
  const modules = document.querySelectorAll('.module');

  if (!orangeContainer && !blueContainer) {
    return;
  }

  window.addEventListener('scroll', () => {
    isInViewport();
  });

  const isInViewport = () => {
    orangeContainer.forEach(item => {
      let bounding = item.getBoundingClientRect();

      if (bounding.top <= (window.innerHeight / 2) && bounding.bottom >= (window.innerHeight / 2)) {
        document.body.classList.add('background-primary-orange');
      } else if (bounding.top < 0 && bounding.bottom <= (window.innerHeight / 2)) {
        document.body.classList.remove('background-primary-orange');
      } else {
        document.body.classList.remove('background-primary-orange');
      }
    });

    blueContainer.forEach(item => {
      let bounding = item.getBoundingClientRect();

      if (bounding.top <= (window.innerHeight / 2) && bounding.bottom >= (window.innerHeight / 2)) {
        console.log('blue in viewport');
        document.body.classList.add('background-primary-blue');
      } else if (bounding.top < 0 && bounding.bottom <= (window.innerHeight / 2)) {
        console.log('blue past viewport');
        document.body.classList.remove('background-primary-blue');
      } else {
        document.body.classList.remove('background-primary-blue');
      }
    });
  };
};

export default initBackgroundColorChange;
