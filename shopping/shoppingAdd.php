<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/minfamilie/inc/db.inc.php';
    $title = $_GET['item'];
    $amount = $_GET['amount'];
    $family = $_GET['family_id'];
    $price = $_GET['price'];
    if(empty($price)){
        $price = "null";
    }

    $sql = "INSERT INTO shoppingItems(title, status, family_id, amount, price) VALUES($title, 0, $family, $amount, $price)";
    echo $sql;
    if(!$result = $con -> query($sql)){
        echo "wrong";
    }
?>
