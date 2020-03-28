<?php
    // settings
    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "minfamilie";

    // the connection to db
    $conn = mysqli_connect(
        $servername, $username, $password, $dbname
    );
    mysqli_set_charset($conn, "utf-8"); 
    
    // check
    if (!$conn) {
        die("Kobling mot database mislyktes!");
    }
?>