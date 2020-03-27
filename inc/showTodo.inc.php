<?php
    include '../inc/db.inc.php';
    date_default_timezone_set("Europe/Oslo");

    function delete($id, $con){
        $sql = "DELETE FROM todo WHERE id = $id";
        $result = $con -> query($sql);
    }
    function show($result, $con){
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
            delete($id, $con);
          }
          else{
            $delete = False;
          }
        }
        else{
          $delete = False;
        }

        if($delete == false){
          echo "<li id=\"entity$id\">";
          echo "<section class=\"wrapper\">";
          echo "<input type=\"checkbox\" class=\"checkbox\" id=\"item$id\" onclick=\"check(this.id, $id, window.location);\" $checked autocomplete=\"off\">";
          echo "<label class= \"text\" id=\"text$id\" for=\"item$id\">$text</label><br>";
          echo "</section>";
          echo "<button class=\"delButton\" id=\"del$id\" onclick=\"delItem($id)\">&times;</button>";
          echo "</li>";
        }
      }
    }
    function main($con, $userID, $familyID){
      // Check if event is private or public for family
      if($familyID == 0){
        $sql = "SELECT * FROM todo WHERE user_id = $userID AND family_id = $familyID ORDER BY time DESC";
      }
      else{
        $sql = "SELECT * FROM todo WHERE family_id = $familyID ORDER BY time DESC";
      }

      $result = $con -> query($sql);
      if ($result -> num_rows > 0){
        show($result, $con);
      }
      else{
        echo "Listen er visst tom. Du har enten gjort alt allerede, eller så er det fortsatt ting du kan legge til. ";
      }
    }

    main($con, $userID, $familyID);
 ?>
