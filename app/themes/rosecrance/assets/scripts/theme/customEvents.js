const getInsuranceSubmitEvent = (insuranceType, formattedInsuranceType) => {
  return new CustomEvent('insuranceTypeSubmit', {
    detail: {
      insuranceType,
      formattedInsuranceType
    }
  });
}

const getZipCodeSubmitEvent = zip => {
  return new CustomEvent('zipCodeSubmit', {
    detail: {
      zip
    }
  });
}

const getStaffBioClickEvent = staffName => {
  return new CustomEvent('staffBioClick', {
    detail: {
      staffName
    }
  });
}

export { getInsuranceSubmitEvent, getZipCodeSubmitEvent, getStaffBioClickEvent };