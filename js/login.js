function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId());
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail());
    var id_token = googleUser.getAuthResponse().id_token;


    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', 'http://localhost/minfamilie/inc/check_token.php')
    onload = function() {
      console.log('Signed in as: ' + xhttp.responseText);
    };
    xhttp.send('token=' + id_token);
}


function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
    });
}
