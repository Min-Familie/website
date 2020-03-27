var input = document.getElementById("location");
var mapOptions = {
  zoom: 14,
  center: {lat: 59.95303107865032, lng: 10.910321279245338},
  zoomControl: true,
  mapTypeControl: true,
  scaleControl: true
}


let options = {
  enableHighAccuracy: true,
  timeout: 5000,
  maximumAge: 0
}
function changeMarkerPosition(marker, cord) {
    marker.setPosition(cord);
    input.value = cord.lat() + ',' + cord.lng();
}
function initMap(mapOptions){
  map = new google.maps.Map(document.getElementById('map'), mapOptions);
  var marker = new google.maps.Marker({
    position: mapOptions.center,
    map: map
  });
  return marker;
}
function success(position){
  let crd = position.coords;
  let coords = {lat: crd.latitude, lng: crd.longitude}
  input.value = coords.lat + ',' + coords.lng;
  mapOptions.center = coords;
  var marker = initMap(mapOptions);
  google.maps.event.addListener(map, 'click', function(event) {
    changeMarkerPosition(marker, event.latLng);
  });

}
function error(err){
  console.log(`Error(${err.code}): ${err.message}`);
  var marker = initMap(mapOptions);
  input.value = mapOptions.center.lat + ',' + mapOptions.center.lng;
  google.maps.event.addListener(map, 'click', function(event) {
    changeMarkerPosition(marker, event.latLng);
  });
}
navigator.geolocation.getCurrentPosition(success, error, options);
