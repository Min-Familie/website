function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId());
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail());

    var name = profile.getName();
    var image = profile.getImageUrl();
    var email = profile.getEmail();
    var id_token = googleUser.getAuthResponse().id_token;



    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("Login complete.");
            window.location.href = '/minfamilie/index.php';
        }
    };
    xhttp.open("GET", `/minfamilie/inc/check_token.inc.php?token=${id_token}&name=${name}&picture="${image}"&email="${email}"`, true);
    xhttp.send();
}


function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', '/minfamilie/inc/logout.inc.php');
        xhttp.send('logout=true');

    });
    window.location.href = '/minfamilie/index.php';
}
function onLoad() {
     gapi.load('auth2', function() {
       gapi.auth2.init();
     });
  }
