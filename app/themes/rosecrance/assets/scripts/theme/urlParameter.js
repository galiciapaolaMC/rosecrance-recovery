const initUrlParameter = () => {
  const url_parameter = document.querySelector(".url-parameter");
  
  if (url_parameter) {
    const value = url_parameter.getAttribute("data-value");
    const name = url_parameter.getAttribute("data-name");
    
    const url = new URL(window.location.href);
    url.searchParams.set(name, value);

    let newUrlString = [];
    newUrlString = url.toString();

    window.history.pushState(null, null, newUrlString);
  }
};

export default initUrlParameter;
