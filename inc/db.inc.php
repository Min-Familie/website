<?php
    $con = new mysqli("localhost", "root", "", "project");
    if($con->connect_error){
      die('Could not connect');
    }
 ?>
