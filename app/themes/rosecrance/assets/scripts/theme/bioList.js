import { getStaffBioClickEvent } from "./customEvents";

const initBioList = () => {
  const bioLists = document.querySelectorAll(".bio-list");
  const staffBios = document.querySelectorAll(".staff-bio-card");

  bioLists.forEach(bioList => {
    let visible = false;
    const viewMoreButton = bioList.querySelector('.bio-list__button');
    const viewMoreText = viewMoreButton?.getAttribute('data-view-more-text');
    const viewFewerText = viewMoreButton?.getAttribute('data-view-fewer-text');

    const hiddenBiosContainer = bioList.querySelector('.bio-list__view-more-bios-container');

    viewMoreButton?.addEventListener('click', () => {
      if (!visible) {
        hiddenBiosContainer.style.display = 'flex';
        viewMoreButton.innerHTML = viewFewerText;
        visible = true;
      } else {
        hiddenBiosContainer.style.display = 'none';
        viewMoreButton.innerHTML = viewMoreText;
        visible = false;
      }
    })
  });

  staffBios.forEach(staffBio => {
    staffBio.addEventListener('click', e => {
      const staffBioClickEvent = getStaffBioClickEvent(staffBio.getAttribute('data-staff-name'));
      document.dispatchEvent(staffBioClickEvent);
    });
  });
};

export default initBioList;
