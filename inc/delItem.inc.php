<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/minfamilie/inc/db.inc.php';
    $id = $_GET['id'];

    $sql = "DELETE FROM todo WHERE id = $id";

    if ($con -> query($sql) === FALSE) {
      echo "Error: " . $sql . "<br>" . $con->error;
    }


 ?>
