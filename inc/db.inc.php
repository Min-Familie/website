<?php
    $con = new mysqli("localhost:3307", "root", "", "minfamilie");
    if($con->connect_error){
        die('Could not connect');
    }
?>
