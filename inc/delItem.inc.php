<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/minfamilie/inc/db.inc.php';
    $id = $_GET['id'];


    function delShopping($id){
        return "DELETE FROM shoppingItems WHERE id = $id";
    }


    function delTodo($id){
        return "DELETE FROM todo WHERE id = $id";
    }

    if($_GET['m'] == 'todo'){
        $sql = delTodo($id);
    }
    else{
        $sql = delShopping($id);
    }
    if ($con -> query($sql) === FALSE) {
      echo "Error: " . $sql . "<br>" . $con->error;
    }

 ?>
