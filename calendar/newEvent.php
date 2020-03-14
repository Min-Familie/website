***REMOVED***
    require "db/dbConnect.php";

    if (isset($_POST["action"]) && $_POST["action"] == "saveEvent") {
        // legg inn i db
***REMOVED***

    // privat+felles kalender
    $username = "yaikes";
    $family = ["felles", $username];
    $events = [ 
        [
            "author"      => "test",
            "title"       => "ja",
            "location"    => "ja",
            "startHour"   => 1,
            "startMinute" => 45,
            "duration"    => 90
        ],
        [
            "author"      => "test",
            "title"       => "ja",
            "location"    => "ja",
            "startHour"   => 3,
            "startMinute" => 15,
            "duration"    => 90
        ]
    ];
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Kalender - Dag</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css"  href="css/day.css">
        <link rel="stylesheet" type="text/css"  href="css/new.css">
        <link rel="icon"       type="image/png" href="favicon.png">
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL3SfCco316MoS6PdhzqjIg0vII5_vcyM&parameters" type="text/javascript"></script>
        <script src="https://unpkg.com/location-picker/dist/location-picker.min.js" type="text/javascript"></script>
    </head>
    <body>
        <h1>Ny event</h1>

        <aside id="map"></aside>

        <form action="newEvent.php"  method="post"   id="eventForm"> 
            <input  type="hidden"    name="action"   value="saveEvent">
            <input  type="text"      name="title"    placeholder="tittel">

            <input  type="text"      name="location" id="location">

            <label  for="day"> start</label>
            <input  type="date"      name="day"  id="day"  ***REMOVED*** if (isset($_GET["day"])) {echo "value=".$_GET["day"];}***REMOVED***>
            <input  type="time"      name="time" ***REMOVED*** if (isset($_GET["hrs"]) && isset($_GET["qrt"])) {echo "value=".substr("0".rtrim($_GET["hrs"], " ").":", -3).substr("0".$_GET["qrt"]*15, -2);}***REMOVED***>

            <label  for="endTime"> slutt</label>
            <input  type="time"      name="endTime"  id="endTime">

            <label  for="privat/public"> privat</label>
            <input  type="checkbox"  name="private"  id="privat/public">

            <select name="felleskalender" form="eventForm">
                <option value="" disabled selected>felleskalender</option>
                <option value="Skarpnes">Skarpnes</option>
                <option value="Alinejad">Alinejad</option>
            </select>

            <input  type="submit"    value="lagre">
        </form> 

        ***REMOVED*** include "calendarDay.php";***REMOVED***

        <script type="text/javascript" src="map.js"></script>
    </body>
</html>