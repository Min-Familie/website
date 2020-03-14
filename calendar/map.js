var lat0 = 59.95303107865032;
var lng0 = 10.910321279245338;
var zoom0 = 14;

// id til HTML tagger
var input = document.getElementById("location");
var map = document.getElementById("map");

// initijalisering av kartet
var lp = new locationPicker(
    map,
    {lat: lat0, lng: lng0},
    {zoom: zoom0}
);

// leser av koordinatene og setter dem inn inputfeltet
google.maps.event.addListener(lp.map, "idle", function () {
    var location = lp.getMarkerPosition();
    input.value = location.lat + ',' + location.lng;
});