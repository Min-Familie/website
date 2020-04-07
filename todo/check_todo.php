<?php
    date_default_timezone_set("Europe/Oslo");
    require $_SERVER['DOCUMENT_ROOT'] . '/minfamilie/inc/db.inc.php';
    $status = $_GET['s'];
    $id = $_GET['id'];

    if($status != 0){   $sql = "UPDATE todo SET time = NOW(), status = $status WHERE id = $id";}
    else{               $sql = "UPDATE todo SET time = null, status = $status WHERE id = $id";}

    $con -> query($sql);
 ?>
