const ROSECRANCE_VISIT_LOG = 'rcvl'; 

const getVisitLogCookie = () => {
  let cookieArray = document.cookie.split(';');
  for(let i = 0; i < cookieArray.length; i++) {
      let cookiePair = cookieArray[i].split('=');
      if(ROSECRANCE_VISIT_LOG === decodeURIComponent(cookiePair[0].trim())) {
          const jsonString = decodeURIComponent(cookiePair[1]);
          return JSON.parse(jsonString);
      }
  }
  return {};
}

const initVisitLog = () => {
  const CONDITIONS_VIEWED_KEY = 'conditionsViewed';
  const PROGRAMS_VIEWED_KEY = 'programsViewed';
  const SERVICES_VIEWED_KEY = 'servicesViewed';
  const RESOURCES_VIEWED_KEY = 'resourcesViewed';
  const LOCATIONS_VIEWED_KEY = 'locationsViewed';
  const STAFF_VIEWED_KEY = 'staffViewed';
  const ZIP_CODE_KEY = 'zipCode';
  const INSURANCE_TYPE_KEY = 'insuranceType';
  const VISIT_QUEUE_SIZE = 2;

  const setVisitLogCookie = (visitLog) => {
    const jsonString = JSON.stringify(visitLog);
    document.cookie = `${encodeURIComponent(ROSECRANCE_VISIT_LOG)}=${encodeURIComponent(jsonString)}; path=/`;
  }
  
  const updateVisitLog = (key, value) => {
    const visitLog = getVisitLogCookie();
    const keyExists = key in visitLog;
    if (!keyExists) {
      visitLog[key] = [value];
    } else {
      if (!visitLog[key].includes(value)) {
        visitLog[key].push(value);
      }
    }
    setVisitLogCookie(visitLog);
  }

  const logLastPageVisited = () => {
    const url = window.location.href;
    const visitLog = getVisitLogCookie();

    if (!visitLog['pageQueue']) {
      visitLog['pageQueue'] = [];
    }

    visitLog['pageQueue'].push(url);
 
    if (visitLog['pageQueue'].length > VISIT_QUEUE_SIZE) {
      visitLog['pageQueue'].shift();
    }
    setVisitLogCookie(visitLog);
  }

  const checkForConditionsPage = () => {
    const conditionWrapper = document.querySelector('.conditions-detail-page');
    if (conditionWrapper !== null) {
      const url = window.location.href;
      updateVisitLog(CONDITIONS_VIEWED_KEY, url);
    }
  }

  const checkForProgramsPage = () => {
    const programWrapper = document.querySelector('.programs-detail-page');
    if (programWrapper !== null) {
      const url = window.location.href;
      updateVisitLog(PROGRAMS_VIEWED_KEY, url);
    }
  }

  const checkForServicesPage = () => {
    const serviceWrapper = document.querySelector('.services-detail-page');
    if (serviceWrapper !== null) {
      const url = window.location.href;
      updateVisitLog(SERVICES_VIEWED_KEY, url);
    }
  }

  const checkForResourcesPage = () => {
    const podcastWrapper = document.querySelector('.podcast-detail-page');
    const videoWrapper = document.querySelector('.video-detail-page');
    const blogArticleWrapper = document.querySelector('.blog-article-detail-page');
    const extendedArticleWrapper = document.querySelector('.extended-article-detail-page');
    const drugFactsWrapper = document.querySelector('.drug-fact-sheet-detail-page');

    const resourceTypes = [podcastWrapper, videoWrapper, blogArticleWrapper, extendedArticleWrapper, drugFactsWrapper];
    const resourceWrapper = resourceTypes.find((resource) => resource !== null);
    if (resourceWrapper) {
      const url = window.location.href;
      updateVisitLog(RESOURCES_VIEWED_KEY, url);
    }
  }

  const checkForLocationsPage = () => {
    const locationWrapper = document.querySelector('.location-detail-page');
    if (locationWrapper !== null) {
      const url = window.location.href;
      updateVisitLog(LOCATIONS_VIEWED_KEY, url);
    }
  }

  const listenForZipCode = () => {
    document.addEventListener('zipCodeSubmit', handleZipCodeChange);
  }

  const handleZipCodeChange = e => {
    if (e.detail.zip) {
      const visitLog = getVisitLogCookie();
      visitLog[ZIP_CODE_KEY] = e.detail.zip;
      setVisitLogCookie(visitLog);
    }
  }

  const listenForInsuranceTypeChange = () => {
    document.addEventListener('insuranceTypeSubmit', handleInsuranceTypeChange);
  }

  const handleInsuranceTypeChange = e => {
    if (e.detail.formattedInsuranceType) {
      const visitLog = getVisitLogCookie();
      visitLog[INSURANCE_TYPE_KEY] = e.detail.formattedInsuranceType;
      setVisitLogCookie(visitLog);
    }
  }

  const listenForTherapistBioModal = () => {
    document.addEventListener('staffBioClick', handleTherapistBioModal);
  }

  const handleTherapistBioModal = e => {
    if (e.detail.staffName) {
      updateVisitLog(STAFF_VIEWED_KEY, e.detail.staffName);
    }
  }

  const setupListeners = () => {
    checkForConditionsPage();
    checkForProgramsPage();
    checkForServicesPage();
    checkForResourcesPage();
    checkForLocationsPage();
    listenForZipCode();
    listenForInsuranceTypeChange();
    listenForTherapistBioModal();
    logLastPageVisited();
  }

  setupListeners();
}

export { initVisitLog, getVisitLogCookie };