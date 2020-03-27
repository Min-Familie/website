<?php

    require '../inc/db.inc.php';
    $status = $_GET['s'];
    $id = $_GET['id'];

    if($status != 0){   $sql = "UPDATE shopping SET time = NOW(), status = $status WHERE id = $id";}
    else{               $sql = "UPDATE shopping SET time = null, status = $status WHERE id = $id";}

    $con -> query($sql);

 ?>
