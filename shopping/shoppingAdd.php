<?php
    include "../inc/db.inc.php";
    $title = $_GET['item'];
    $amount = $_GET['amount'];
    $family_id = $_GET['family_id'];
    $price = $_GET['price'];
    if(empty($price)){
        $price = "null";
    }
    $sql = "INSERT INTO shopping(title, status, family_id, amount, price) VALUES($title, 0, $family_id, $amount, $price)";
    echo $sql;
    if(!$result = $con -> query($sql)){
        echo "wrong";
    }

?>
