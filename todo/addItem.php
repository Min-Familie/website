***REMOVED***
    include '../inc/db.inc.php';
    if(isset($_GET['t'])){
      $todo = $_GET['t'];
      $sql = "INSERT INTO todo(text) VALUES($todo)";

      if ($con->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $con->error;
  ***REMOVED***
***REMOVED***
    else if (isset($_GET['id']) && isset($_GET['s'])){
      $id = $_GET['id'];
      $status = $_GET['s'];

      $sql = "UPDATE todo SET status = $status WHERE id = $id";
      if ($con->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $con->error;
  ***REMOVED***

***REMOVED***
    else {
      echo "An error occured";
***REMOVED***



    $con->close();
***REMOVED***
