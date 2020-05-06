<?php
    session_start();
    require $_SERVER['DOCUMENT_ROOT'] . '/minfamilie/inc/db.inc.php';
    $title = $_GET['item'];
    $amount = $_GET['amount'];
    $family = $_SESSION['family_id'];
    $price = $_GET['price'];
    if(empty($price)){
        $price = "null";
    }
    $price = round($price) * $amount;

    $sql = "INSERT INTO shoppingItems(title, status, family_id, amount, price) VALUES($title, 0, $family, $amount, $price)";
    if(!$result = $con -> query($sql)){
        echo "wrong";
    }
    $con->close();
?>
