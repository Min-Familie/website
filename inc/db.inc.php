<?php
    // settings
    // $servername = "mysql.elev.stolav.it";
    // $username = "skaben";
    // $password = "M0a0Makrell";
    // $dbname = "stolav19_skaben";

    $servername = "localhost";
    $username = "root";
    $password = "ShayKing80";
    $dbname = "project";

    // the connection to db
    $con = mysqli_connect(
        $servername, $username, $password, $dbname
    );
    mysqli_set_charset($con, "utf-8");

    // check
    if (!$con) {
        die("Tilkobling mot db mislyktes");
    }
?>
