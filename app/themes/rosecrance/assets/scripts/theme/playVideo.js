const initPlayVideo = () => {
  const video = document.querySelector(".video-file");
  const playButton = document.querySelector(".play-btn");
  if (video && playButton) {
    playButton.addEventListener("click", function(event) {
      video.play();
      video.controls = "controls";
      playButton.style.display = "none";
    });
  }
};

export default initPlayVideo;
