<?php
    $del = $_POST['logout'];
    session_start();

    session_unset();

    session_destroy();
 ?>
