const initGoBackButton = () => {
  const goBackButtonElement = document.getElementById('go-back-button-container');

  if (goBackButtonElement !== null) {
    goBackButtonElement.style.display = 'block';
    goBackButtonElement.addEventListener('click', handleResourceButtonClick);
  }
}

const handleResourceButtonClick = (e) => {
  history.back();
}

export default initGoBackButton;