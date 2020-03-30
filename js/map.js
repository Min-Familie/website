var input = document.getElementById("location");

let options = {
    enableHighAccuracy: true,
    timeout: 50000,
    maximumAge: 0
}

function changeMarkerPosition(marker, cord) {
    marker.setPosition(cord);
    input.value = cord.lat() + "," + cord.lng();
}

function initMap(mapOptions){
    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    var marker = new google.maps.Marker({
        position: mapOptions.center,
        map: map
    });
    return marker;
}

function success(position){
    let crd = position.coords;
    let coords = {lat: crd.latitude, lng: crd.longitude}
    input.value = coords.lat + "," + coords.lng;
    mapOptions.center = coords;
    var marker = initMap(mapOptions);
    google.maps.event.addListener(map, "click", function(event) {
        changeMarkerPosition(marker, event.latLng);
    });
}

function error(err){
    console.log(`Error(${err.code}): ${err.message}`);
    var marker = initMap(mapOptions);
    input.value = mapOptions.center.lat + "," + mapOptions.center.lng;
    google.maps.event.addListener(map, "click", function(event) {
        changeMarkerPosition(marker, event.latLng);
    });
}
