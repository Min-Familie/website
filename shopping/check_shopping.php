<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/minfamilie/inc/db.inc.php';
    $status = $_GET['s'];
    $id = $_GET['id'];

    if($status != 0){   $sql = "UPDATE shoppingItems SET time = NOW(), status = $status WHERE id = $id";}
    else{               $sql = "UPDATE shoppingItems SET time = null, status = $status WHERE id = $id";}


?>
