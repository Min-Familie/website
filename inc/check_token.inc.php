<?php
    require '../vendor/autoload.php';

    require $_SERVER['DOCUMENT_ROOT'] . '/test2/inc/db.inc.php';

    $token = $_GET['token'];


    $client = new Google_Client(['client_id' => '280130080722-8ruhprpjaqt1vorhd8s245l9gtqgmr61.apps.googleusercontent.com']);  // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($token);


    if ($payload) {
        $userid = $payload['sub'];
        $check_sql = "SELECT * FROM users WHERE username = \"$userid\"";
        $result = $con -> query($check_sql);
        if ($result -> num_rows < 1){
            $sql = "INSERT INTO users (id, username, forename, surname, picture_link, email) VALUES ($userid, \"test\", \"test\", \"test\", \"test\", \"test\");";
            if (!$result = $con -> query($sql)){
                echo "wrong";
            }
        }
    // If request specified a G Suite domain:
    //$domain = $payload['hd'];
    }
    else {
        echo "no";
    }

    echo $sql;
?>