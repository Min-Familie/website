<?php
    session_start();
    require '../vendor/autoload.php';

    require $_SERVER['DOCUMENT_ROOT'] . '/minfamilie/inc/db.inc.php';

    $token = $_GET['token'];
    $name = $_GET['name'];
    $picture = $_GET['picture'];
    $email = $_GET['email'];

    $name = explode(' ', $name);
    if(!isset($name[1])){
        $name[1] = " ";
    }
    $client = new Google_Client(['client_id' => '71847374517-d19h9ttcihhtftg0q4ibjrpirdmjd71t.apps.googleusercontent.com']);
    $payload = $client->verifyIdToken($token);


    if ($payload) {
        $userid = $payload['sub'];
        $_SESSION['id'] = $userid;
        $check_sql = "SELECT * FROM users WHERE id = $userid";
        $result = $con -> query($check_sql);
        if ($result -> num_rows == 0){
            $sql = "INSERT INTO users (id, forename, surname, picture_link, email) VALUES ($userid, \"$name[0]\", \"$name[1]\", $picture, $email)";
            if (!$result = $con -> query($sql)){
                echo $sql;
            }
        }
    }
    else {
        echo "no";
    }
?>
