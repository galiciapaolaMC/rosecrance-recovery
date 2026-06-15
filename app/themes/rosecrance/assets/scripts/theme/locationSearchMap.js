import { Loader } from '@googlemaps/js-api-loader';

const initLocationSearchMap = () => {
  const mapContainer = document.querySelector("#map-results");

  if (typeof window.location_map === 'undefined' || !mapContainer) {
    return;
  }
  let geocodingLoaded = false;
  const protocol = window.location.protocol;
  const hostname = window.location.hostname;
  const regionsRestBase = protocol + '//' + hostname + '/wp-json/locations-by-region-rest/v1';
  const zipcodeRestBase = protocol + '//' + hostname + '/wp-json/locations-by-zipcode-rest/v1';
  const restBase = protocol + '//' + hostname + '/wp-json/locations-rest/v1';
  const restBaseVirtual = protocol + '//' + hostname + '/wp-json/virtual-locations-rest/v1';
  const restBaseMap = protocol + '//' + hostname + '/wp-json/locations-map-rest/v1';
  const restParamID = protocol + '//' + hostname + '/wp-json/parameters-id-rest/v1';
  const target = document.querySelector('#location-list');
  const targetVirtual = document.querySelector('#virtual-locations');
  const searchButton = document.querySelector('#search-location');
  const toggleRegions = document.querySelector('#toggle-regions');
  const useLocation = document.querySelector("#use-location");
  const zipCodeFilterContainer = document.querySelector('.zipcode-control-container');
  const zipCode = document.querySelector("input[name='filter_zipcode']");
  const regionControlContainer = document.querySelector('.region-control-container');
  const region = document.querySelector("select[name='filter_regions']");
  const programControlContainer = document.querySelector('.program-control-container');
  const program = document.querySelector("select[name='filter_programs']");
  const serviceControlContainer = document.querySelector('.service-control-container');
  const service = document.querySelector("select[name='filter_services']");
  const noResults = document.querySelector(".list-result__no-results");
  const noResultsText = noResults?.querySelector('p');
  const locationModeToggle = document.querySelector('[data-toggle-name="location-mode"]');
  const locationModeCheckBox = document.querySelector('[name="location-mode"]');
  const clearFilter = document.querySelector("#clear-filter");``
  const GOOGLE_MAPS_API_KEY = window.location_map.maps_api_key ?? null;
  const GOOGLE_MAP_ID = window.location_map.maps_map_id ?? null;
  const ZIPCODE_API_KEY = window.location_map.zipcode_api_key ?? null;
  const url = new URL(window.location.href);
  let locationMode = 'zip-code';
  let programs_input = document.querySelector('input[name="programs_list"]');
  let services_input = document.querySelector('input[name="services_list"]');
  let programs_list = '';
  let services_list = '';
  
  // URL PARAMETERS TO FILTER
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  let zipCodeParam = urlParams.get('zip-code');
  let locationModeParam = urlParams.get('location-mode');
  let regionParam = urlParams.get('region');
  let programParam = urlParams.get('program');
  let serviceParam = urlParams.get('service');
  let insuraceParam = urlParams.get('insurance-provider');

  const setFieldValue = (name, value) => {
    const associatedButton = document.querySelector(`button[aria-controls="${name}_select-field_dropdown"]`);
    let field;
    // if ID is passed
    if (!isNaN(value)) {
      field = document.querySelector(`input[name="${name}"][value="${value}"]`);
    // if slug is passed
    } else {
      field = document.querySelector(`input[name="${name}"][data-filter-value="${value}"]`);
    }
    if (field) {
      field.checked = true;
      const event = new Event('change');
      field.dispatchEvent(event);

      // Prevent dropdown from staying open on page load
      associatedButton.click();
    }
  }
    
  const getRegionValueFromField = () => {
    return document.querySelector('input[name="regions"]:checked')?.value || '';
  }

  const getServiceValueFromField = () => {
    return document.querySelector('input[name="services"]:checked')?.value || '';
  }

  const getProgramValueFromField = () => {
    return document.querySelector('input[name="programs"]:checked')?.value || '';
  }

  const initZipCodeMode = () => {
    zipCodeFilterContainer.style.display = 'block';
    regionControlContainer.style.display = 'none';
    setFieldValue('regions', '');
    url.searchParams.set("location-mode", "zip-code");
  }

  const initRegionMode = () => {
    zipCodeFilterContainer.style.display = 'none';
    zipCode.value = '';
    regionControlContainer.style.display = 'block';
    url.searchParams.set("location-mode", "region");
  }

  if (toggleRegions) {
    toggleRegions.addEventListener('click', () => {
      locationMode = 'region';
      initRegionMode();
      locationModeCheckBox.checked = true;
      toggleRegions.style.display = 'none';
      searchButton.click();
    });
  }

  if (locationModeParam) {
    if (locationModeParam === 'region') {
      locationMode = 'region';
      initRegionMode();
      locationModeCheckBox.checked = true;
    } else {
      locationMode = 'zip-code';
      initZipCodeMode();
      locationModeCheckBox.checked = false;
    }
  }

  if (zipCodeParam) {
    zipCode.value = zipCodeParam;
  }
  
  // ACTIVATE GEOLOCATOR
  const geocodinLoader  = () => {
    try {
      const { Geocoder } = MapLoader.importLibrary('geocoding');
      this.maps.Geocoder = new Geocoder();
      geocodingLoaded = true;
      useLocation.remove();
    } catch (e) {
      console.log('Geocoder error', e);
    }
  }

  // GET LIST RESULTS
  const getVirtualListResults = (program, service, insuranceProvider) => {
    
    let data = {
      'action' : 'virtual_locations_rest',
      program: program,
      service: service,
      insuranceProvider: insuranceProvider
    };

    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': virtual_locations_rest.apiNonce,
      },
      credentials: 'same-origin',
      body: JSON.stringify({
        data: data,
      }),
    };

    fetch(restBaseVirtual + '/search?date=' + Date.now(), options)
      .then((response) => {
        if (!response.ok) {
          const statusError = 'Error getting Search from API';
          if (response.status === 403) {
            console.log('Nonce Error');
          }
          throw new Error(statusError);
        } else {
          return response.json();
        }
      })
      .then((response) => {
        if (response && response.posts !== '') {
          targetVirtual.innerHTML = response.posts;
        } else {
          targetVirtual.innerHTML = '';
        }
      })
      .catch((response) => {
        console.log(response);
      });
  }

  const getLocationsByZipCode = (zipCodes, program, service, insuranceProvider) => {
    const data = {
      'action' : 'locations_by_zip_code_rest',
      zipCodes: zipCodes,
      program: program,
      service: service,
      insuranceProvider: insuranceProvider
    }
    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': locations_by_zip_code_rest.apiNonce,
      },
      credentials: 'same-origin',
      body: JSON.stringify({
        data: data
      }),
    };

    fetch(zipcodeRestBase + '/search?date=' + Date.now(), options)
      .then((response) => {
        if (!response.ok) {
          const statusError = 'Error getting Search from API';
          console.log(statusError, response);
          
          if (response.status === 403) {
            console.log('Nonce Error');
          }
          throw new Error(statusError);
        } else {
          return response.json();
        }
      })
      .then((response) => {
        if (response.locations.length === 0) {
          noResults.style.display = 'block';
          noResultsText.innerHTML = window.location_map.no_results_zipcode;
          toggleRegions.style.display = 'block';
          target.innerHTML = '';
          resetMap();
        } else {
          noResults.style.display = 'none';
          const mapData = response.locations.map(location => {
            return {
              ID: location.id,
              center: {
                lat: parseFloat(location.latitude),
                lng: parseFloat(location.longitude)
              },
              ...location
            }
          });
          clearFilter.style.display = "inline-block";
          loadMapResults(mapData, 6);
          const html = buildLocationsList(response.locations);
          target.innerHTML = html.join('');
        }
      })
      .catch((response) => {
        console.log(response);
      });
  }

  const getLocationsByRegion = (region, program, service, insuranceProvider) => {
    const data = {
      'action' : 'locations_by_region_rest',
      region: region,
      program: program,
      service: service,
      insuranceProvider: insuranceProvider
    }
    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': locations_by_region_rest.apiNonce,
      },
      credentials: 'same-origin',
      body: JSON.stringify({
        data: data
      }),
    };

    fetch(regionsRestBase + '/search?date=' + Date.now(), options)
      .then((response) => {
        if (!response.ok) {
          const statusError = 'Error getting Search from API';
          
          if (response.status === 403) {
            console.log('Nonce Error');
          }
          throw new Error(statusError);
        } else {
          return response.json();
        }
      })
      .then((response) => {
        if (response.locations.length === 0) {
          noResults.style.display = 'block';
          noResultsText.innerHTML = window.location_map.no_results;
          target.innerHTML = '';
          resetMap();
        } else {
          noResults.style.display = 'none';
          const mapData = response.locations.map(location => {
            return {
              ID: location.id,
              center: {
                lat: parseFloat(location.latitude),
                lng: parseFloat(location.longitude)
              },
              ...location
            }
          });
          loadMapResults(mapData, 6);
          clearFilter.style.display = "inline-block";

          const html = buildLocationsList(response.locations);
          target.innerHTML = html.join('');
        }
      })
      .catch((response) => {
        console.log(response);
      });
  }

  const buildLocationListItem = location => {
    const associatedRegions = location.related_regions.map(region => {
      return `
        <p class="region-name">${region}</p>
      `
    });

    const additionalText = location.additional_text ? `<p>${location.additional_text}</p>` : '';
    let locationAddress = '';
    if (location.address) {
      locationAddress = `
        <p>${location.address}</p>
        <a
          class="location-details__directions-link"
          target="_blank"
          href="https://www.google.com/maps/dir/?api=1&destination=${location.latitude},${location.longitude}"
        >
          ${window.location_map.localized_directions}
        </a>
      `
    }

    let phoneNumber = '';
    if (location.phone_number && location.phone_number.url && location.phone_number.title) {
      phoneNumber = `
        <a href="tel:${location.phone_number.url}" class="location-details__phone-number">${location.phone_number.title}</a>
      `
    }

    return `
      <div class="featured-location">
        <div class="location-wrapper">
          ${associatedRegions.join('')}
          <h2>${location.title}</h2>
          <div class="location-details">
            ${additionalText}
            ${locationAddress}
            ${phoneNumber}
          </div>

          <a href="/${location.slug}" class="btn btn-primary">
            ${window.location_map.localized_location_details}
            ${window.location_map.arrow_right_dark}
          </a>
        </div>
      </div>
    `
  }


  const buildLocationsList = locations => {
    return locations.map(location => buildLocationListItem(location));
  }

  const buildInfoWindow = location => {
    let phoneNumber = '';
    if (location.phone_number && location.phone_number.url && location.phone_number.title) {
      phoneNumber = `
        <a href="tel:${location.phone_number.url}" class="info-window-location__phone-number">${location.phone_number.title}</a>
      `
    }
    return `
      <div class="info-window-location">
        <h2>${location.title}</h2>
        ${phoneNumber}
        <a
          class="info-window-location__address"
          target="_blank"
          href="https://www.google.com/maps/dir/?api=1&destination=${location.latitude},${location.longitude}"
        >${location.address}</a>
        <a href="/${location.slug}" class="btn btn-primary">
          ${window.location_map.localized_location_details}
          ${window.location_map.arrow_right_dark}
        </a>
      </div>
    `
  }

  const sanitizePosition = (position) => {
    if (position) {
      const { lat, lng } = position;
      let stringLat = lat.toString().trim();
      let stringLng = lng.toString().trim();

      // if stringLat has an emdash or endash, replace with minus symbol
      if (stringLat.includes('–') || stringLat.includes('—')) {
        stringLat = stringLat.replace('–', '-').replace('—', '-');
      }

      if (stringLng.includes('–') || stringLng.includes('—')) {
        stringLng = stringLat.replace('–', '-').replace('—', '-');
      }
      
      const floatLat = parseFloat(stringLat);
      const floatLng = parseFloat(stringLng);

      if (isNaN(floatLat) || isNaN(floatLng)) {
        console.error(`invalid position:`);
        console.log(position);
        return null;
      }

      position = {
        lat: floatLat,
        lng: floatLng
      }

    } else {
      console.error(`invalid position:`);
      console.log(position);
    }
    return position;
  }
  
  // LOAD MAP WITH FILTERED LOCATIONS
  const loadMapResults = (mapResults, distance) => {
    
    const loader = new Loader({
      apiKey: GOOGLE_MAPS_API_KEY,
      version: "weekly",
    });

    // Promise for a specific library
    loader
    .importLibrary('maps')
    .then(async ({Map}) => {
      // ADD MAP ID TO .ENV
      const mapOptions = {
        mapId: GOOGLE_MAP_ID,
        center: mapResults[0].center,
        zoom: 6,
      };
      
      const map = new Map(mapContainer, mapOptions);
      const { InfoWindow } = await loader.importLibrary('maps');
      const {AdvancedMarkerElement, PinElement} = await loader.importLibrary('marker');

      const infoWindow = new InfoWindow();
      mapResults.forEach(function(result){
        const position = sanitizePosition(result.center);
        if (!position) {
          console.error(`skipped plotting ${result.title} on map due to invalid longitude or latitude.`);
          return;
        }
        const markerColor = new PinElement({
          background: "#FAA834",
          borderColor: "#FAA834",
          glyphColor: 'white',
        });
  
        const marker = new AdvancedMarkerElement({
          map, 
          position,
          content: markerColor.element,
        });

        marker.addListener('click', e => {
          infoWindow.close();
          infoWindow.setContent(buildInfoWindow(result));
          infoWindow.open(map, marker);
        });
      });
    })
    .catch((e) => {
      console.error(e);
    });

    setTimeout(function(){
      target.style.display = 'block';
    }, 200);
  }

  // LOAD EMPTY MAP
  const resetMap = (latitudeData, longitudeData) => {
    lat = latitudeData ?? 43.025295;
    long = longitudeData ?? -89.9471465;

    const loader = new Loader({
      apiKey: GOOGLE_MAPS_API_KEY,
      version: "weekly",
    });

    // Promise for a specific library
    loader
    .importLibrary('maps')
    .then(async ({Map}) => {

      // ADD MAP ID TO .ENV
      const mapOptions = {
        mapId: GOOGLE_MAP_ID,
        center: {
          lat: lat,
          lng: long
        },
        zoom: 6,
      };
      
      const map = new Map(mapContainer, mapOptions);
    })
    .catch((e) => {
      console.error(e);
    });
  }

  if (searchButton) {
    searchButton.addEventListener("click", () => {
      const regionValue = getRegionValueFromField();
      const programValue = getProgramValueFromField();
      const serviceValue = getServiceValueFromField();

      if (regionValue) {
        zipCodeParam = '';
        regionParam = regionValue;
        url.searchParams.set("region", regionValue);
        url.searchParams.delete("zip-code");
      } else {
        regionParam = '';
        url.searchParams.delete("region");
      }

      if (programValue) {
        programParam = programValue;
        url.searchParams.set("program", programValue);
      } else {
        programParam = '';
        url.searchParams.delete("program");
      }

      if (serviceValue) {
        serviceParam = serviceValue;
        url.searchParams.set("service", serviceValue);
      } else {
        serviceParam = '';
        url.searchParams.delete("service");
      }

      if (locationMode === 'zip-code' && !zipCode.value == '') {
        regionParam = '';
        zipCodeParam = zipCode.value;
        url.searchParams.delete("region");
        url.searchParams.set("zip-code", zipCode.value);
      } else if (locationMode === 'region') {
        zipCodeParam = '';
        url.searchParams.delete("zip-code");
        regionParam = regionValue;
        url.searchParams.set("region", regionValue);
      }

      if (zipCodeParam) {
        getCloseZipCodes(zipCodeParam);
      } else {
        getLocationsByRegion(regionParam, programParam, serviceParam, insuraceParam);
      }

      getVirtualListResults(programParam, serviceParam, insuraceParam);

      let newUrlString = [];
      newUrlString = url
        .toString();

      window.history.pushState(null, null, newUrlString);
    });
  }

  const setFilter = (region, program, service) => {
    console.log(region, program, service);
    if (region) setFieldValue('regions', region);
    if (program) setFieldValue('programs', program);
    if (service) setFieldValue('services', service);
  }

  if (mapContainer) {
    let map;
    target.style.display = 'none';
    
    if (zipCodeParam) {
      getCloseZipCodes(zipCodeParam);
    } else {
      getLocationsByRegion(regionParam, programParam, serviceParam, insuraceParam);
    }
  }

  // FILTER MAP BY URL PARAMETERS
  if (regionParam || programParam || serviceParam || zipCodeParam || insuraceParam) {
    if (zipCodeParam) {
      getCloseZipCodes(zipCodeParam);
    } else {
      getLocationsByRegion(regionParam, programParam, serviceParam, insuraceParam);
    }

    getVirtualListResults(programParam, serviceParam, insuraceParam);
    setFilter(regionParam, programParam, serviceParam);
  }

  // API CALL ZIP CODES
  function getCloseZipCodes(zipCodeParam) {
    if (zipCodeParam && ZIPCODE_API_KEY) {
      let radius = 500;

      let text = '';
      const apiUrl = 'https://www.zipcodeapi.com/rest/'+ZIPCODE_API_KEY+'/radius.json/'+zipCodeParam+'/'+radius;
      const xhttpr = new XMLHttpRequest();
      xhttpr.open('GET', apiUrl, true);
      
      xhttpr.send();
      
      xhttpr.onload = ()=> {
        if (xhttpr.status === 200) {
            const response = JSON.parse(xhttpr.response);
            
            let zipCodes = response.zip_codes.map( zipCode => {
              const { zip_code, distance } = zipCode;
              return { value: zip_code, distance };
            });

            zipCodes = [{ value: zipCodeParam, distance: 0 }, ...zipCodes];
            const flattenedZipCodes = zipCodes.map( zipCode => zipCode.value).toString();
            
            getLocationsByZipCode(zipCodes, programParam, serviceParam, insuraceParam);
        } else {
          // Handle error
          console.log('Error', xhttpr.statusText);
        }
      };
    }
  }

  if (locationModeCheckBox) {
    locationModeCheckBox.addEventListener('change', (e) => {
      const { target } = e;
      const { checked } = target;

      if (checked) {
        locationMode = 'region';
        initRegionMode();
      } else {
        locationMode = 'zip-code';
        initZipCodeMode();
      }
      
    });
  }

  // CLEAR FILTERS
  if (clearFilter) {
    clearFilter.addEventListener("click", () => {    
      document.querySelectorAll('.select-filter').forEach((select) => {
        select.selectedIndex = 0;
      });
      url.searchParams.delete("zip-code");
      url.searchParams.delete("region");
      url.searchParams.delete("program");
      url.searchParams.delete("service");
      const fieldStateReset = new CustomEvent('fieldStateReset', {
        detail: {
          fieldNames: ['regions', 'programs', 'services'],
        },
        bubbles: true
      });
      document.dispatchEvent(fieldStateReset);
      url.searchParams.set("location-mode", "region");
      
      initRegionMode();
      locationModeCheckBox.checked = true;
      window.history.pushState(null, null, url);

      getLocationsByRegion();
      clearFilter.style.display = "none";
    });
  }
};

export default initLocationSearchMap;
