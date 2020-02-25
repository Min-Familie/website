***REMOVED***
    include '../inc/db.inc.php';

    $sql = "SELECT * FROM todo";
    $result = $con -> query($sql);
    if($result -> num_rows > 0){
      while($row = $result -> fetch_assoc()){
        $id = $row['id'];
        $text = $row['text'];
        $status = $row['status'];
        if($status != 0){
          $checked = "checked";
          $style = "style = \"text-decoration:line-through\"";
    ***REMOVED***
        else {
          $checked = "";
          $style = "";
    ***REMOVED***
        echo "<input type=\"checkbox\" id=\"item$id\" onclick=\"checkMark($id)\" $checked autocomplete=\"off\">";
        echo "<label id=\"label$id\" for=\"item$id\" $style>$text</label><br>";
  ***REMOVED***
***REMOVED***
    else{
      printf("Listen er tom");
***REMOVED***


***REMOVED***
