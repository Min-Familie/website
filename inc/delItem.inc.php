<?php
    $id = $_GET['id'];
    include $_SERVER['DOCUMENT_ROOT'] . '/minfamilie/inc/db.inc.php';


    function delShopping($id){
        return "DELETE FROM shoppingItems WHERE id = $id";
    }


    function delTodo($id){
        return "DELETE FROM todo WHERE id = $id";
    }

    if($_GET['m'] == 'todo'){
        $user_id = $_GET['user_id'];
        $family_id = $_GET['family_id'];
        $sql = delTodo($id);
    }
    else{
        $sql = delShopping($id);
    }
    if ($con -> query($sql) === FALSE) {
      echo "Error: " . $sql . "<br>" . $con->error;
    }
    if($con -> query("SELECT * FROM todo WHERE user_id = $user_id AND family_id = $family_id") -> num_rows == 0){
        echo 'empty';
    }




 ?>
