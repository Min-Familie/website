<?php

    require_once '../vendor/autoload.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/minfamilie/inc/db.inc.php';
    $token = $_POST['token']

    $client = new Google_Client(['client_id' => '280130080722-8ruhprpjaqt1vorhd8s245l9gtqgmr61']);  // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($token);
    if ($payload) {
      $userid = $payload['sub'];
      $sql = "INSERT INTO users(username, forename, surname, password) VALUES($userid, \"test\", \"test\", \"test\")"
      if(!$result = $con -> query($sql)){
          echo "wrong";
      }

      // If request specified a G Suite domain:
      //$domain = $payload['hd'];
    } else {
      echo "no"
    }


 ?>
