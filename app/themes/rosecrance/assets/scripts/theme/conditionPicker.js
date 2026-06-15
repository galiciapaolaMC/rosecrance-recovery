const initConditionPicker = () => {
  const button = document.querySelector(".condition-picker__button");
  const selectContainer = document.querySelector('.condition-picker__selector');
  let selectedValue = '';

  if (selectContainer) {
    button.addEventListener("click", function(event) {
      if (selectedValue !== '') {
        window.location.href = selectedValue;
      }
    });

    document.addEventListener('fieldStateChanged', e => {
      if (e) {
        const { detail } = e;
        const { checkedValues } = detail;

        if (checkedValues.length) {
          selectedValue = checkedValues[0];
        }
      }
    })
  }
};

export default initConditionPicker;
