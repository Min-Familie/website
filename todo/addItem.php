***REMOVED***
    include '../inc/db.inc.php';
    if(isset($_GET['t'])){
      $todo = $_GET['t'];
      $familyID = $_GET['family'];
      $userID = $_GET['user'];
      $sql = "INSERT INTO todo(title, time, user_id, family_id) VALUES($todo, null, $userID, $familyID)";
***REMOVED***
    else if (isset($_GET['id']) && isset($_GET['s'])){
      $id = $_GET['id'];
      $status = $_GET['s'];
      if($status != 0){
        $sql = "UPDATE todo SET time = NOW(), status = $status WHERE id = $id";
  ***REMOVED***
      else{
        $sql = "UPDATE todo SET time = null, status = $status WHERE id = $id";
  ***REMOVED***
***REMOVED***
    else {
      echo "An error occured";
***REMOVED***
    if ($con->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $con->error;
***REMOVED***
    $con->close();
***REMOVED***
