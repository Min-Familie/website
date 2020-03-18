***REMOVED***
    include '../inc/db.inc.php';
    date_default_timezone_set("Europe/Oslo");

    function delete($id, $con){
        $sql = "DELETE FROM todo WHERE id = $id";
        $result = $con -> query($sql);
***REMOVED***
    function show($result, $con){
      while($row = $result -> fetch_assoc()){
        $id = $row['id'];
        $text = $row['title'];
        $status = $row['status'];
        if($status != 0){
          $checked = "checked";
          $style = "style = \"text-decoration:line-through\"";
    ***REMOVED***
        else {
          $checked = "";
          $style = "";
    ***REMOVED***
        if ($row['time'] != null){
          $time = $row['time'];
          $end = new DateTime($time);
          $now = new DateTime();
          $endTime = (int)($end -> modify("+1 day")) -> format("dmYHi");
          $nowTime = (int)($now -> format("dmYHi"));
          if($nowTime >= $endTime){
            $delete = true;
            delete($id, $con);
      ***REMOVED***
          else{
            $delete = false;
      ***REMOVED***
    ***REMOVED***
        else{
          $delete = false;
    ***REMOVED***

        if($row == null || $delete == false){
          echo "<li id=\"entity$id\">";
          echo "<section class=\"wrapper\">";
          echo "<input type=\"checkbox\" class=\"checkbox\" id=\"item$id\" onclick=\"checkMark($id)\" $checked autocomplete=\"off\">";
          echo "<label class= \"text\" id=\"label$id\" for=\"item$id\" $style>$text</label><br>";
          echo "</section>";
          echo "<button class=\"delButton\" id=\"del$id\" onclick=\"delItem($id)\">&times;</button>";
          echo "</li>";
    ***REMOVED***
  ***REMOVED***
***REMOVED***
    function main($con, $userID, $familyID){
      // Check if event is private or public for family
      if($familyID == 0){
        $sql = "SELECT * FROM todo WHERE user_id = $userID AND family_id = $familyID ORDER BY time DESC";
  ***REMOVED***
      else{
        $sql = "SELECT * FROM todo WHERE family_id = $familyID ORDER BY time DESC";
  ***REMOVED***

      $result = $con -> query($sql);
      if ($result -> num_rows > 0){
        show($result, $con);
  ***REMOVED***
      else{
        echo "Listen er visst tom. Du har enten gjort alt allerede, eller så er det fortsatt ting du kan legge til. ";
  ***REMOVED***
***REMOVED***

    main($con, $userID, $familyID);
***REMOVED***
