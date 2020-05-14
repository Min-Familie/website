<?php

    date_default_timezone_set("Europe/Oslo");

    function deleteTodo($id, $con){
        $sql = "DELETE FROM todo WHERE id = $id";
        $result = $con -> query($sql);
    }
    function showTodo($result, $con){
      while($row = $result -> fetch_assoc()){
        $id = $row['id'];
        $text = $row['title'];
        $status = $row['status'];
        if($status != 0){
          $checked = "checked";
        }
        else {
          $checked = "";
        }
        if ($row['time'] != null){
          $time = $row['time'];
          require 'time.inc.php';
          if($delete = timecheck($time)){
            deleteTodo($id, $con);
          }
          else{
            $delete = False;
          }
        }
        else{
          $delete = False;
        }

        if($delete == false){
          echo "<li class=\"todoEntry\" id=\"entity$id\">";
          echo "<section class=\"wrapper\">";
          echo "<input type=\"checkbox\" class=\"checkbox\" id=\"item$id\" onclick=\"check(this.id, $id, 'todo');\" $checked autocomplete=\"off\">";
          echo "<label class= \"text\" id=\"text$id\" for=\"item$id\">$text</label><br>";
          echo "</section>";
          echo "<button class=\"delButton\" id=\"del$id\" onclick=\"delItem($id)\">&times;</button>";
          echo "</li>";
        }
      }
    }
    function mainTodo($con, $user, $family){
      // Check if event is private or public for family
      if($family == 0){
        $sql = "SELECT * FROM todo WHERE user_id = $user AND family_id = 0 ORDER BY time DESC";
      }
      else{
        $sql = "SELECT * FROM todo WHERE family_id = $family ORDER BY time DESC";
      }
      $result = $con -> query($sql);
      if ($result -> num_rows > 0){
        showTodo($result, $con);
      }
      else{
        echo "<p class=\"todoError\">Listen er visst tom. Du har enten gjort alt allerede, eller så er det fortsatt ting du kan legge til. </p>";
      }
    }
    if(isset($_GET['family_id']) && isset($_GET['user_id'])){
        $family_id = $_GET['family_id'];
        $user_id = $_GET['user_id'];
        require 'db.inc.php';

    }
    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
    }

    echo "<ul id=\"entries\">";
    mainTodo($con, $user_id, $family_id);
    echo "</ul>";

 ?>
