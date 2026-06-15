import { Loader } from '@googlemaps/js-api-loader';

const initLocationDetailMap = () => {
  const mapContainer = document.querySelector("#map");
  
  if (mapContainer) {
    const GOOGLE_MAPS_API_KEY = window.location_map.maps_api_key ?? null;
    const GOOGLE_MAP_ID = window.location_map.maps_map_id ?? null;
    const latitude = Number(document.querySelector(".map__latitude").value);
    const longitude = Number(document.querySelector(".map__longitude").value);
    let map;
    
    const loader = new Loader({
      apiKey: GOOGLE_MAPS_API_KEY,
      version: "weekly",
    });

    const mapOptions = {
      mapId: GOOGLE_MAP_ID,
      center: {
        lat: latitude, 
        lng: longitude
      },
      zoom: 13,
    };

    // Promise for a specific library
    loader
    .importLibrary('maps')
    .then(async ({Map}) => {
      const map = new Map(document.getElementById("map"), mapOptions);
      const {AdvancedMarkerElement, PinElement} = await loader.importLibrary('marker');

      const markerColor = new PinElement({
        background: "#FAA834",
        borderColor: "#FAA834"
      });

      new AdvancedMarkerElement({
        map, 
        position: mapOptions.center,
        content: markerColor.element
      });
    })
    .catch((e) => {
      console.error(e);
    });
  }
};

export default initLocationDetailMap;
