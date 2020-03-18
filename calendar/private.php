***REMOVED***
    $user_id = 2;

    require "../db/dbConnect.php";

    // tidssone
    date_default_timezone_set("Europe/Oslo");

    // input dag
    if (isset($_GET["day"])) {$inputDay = $_GET["day"];}
    else                     {$inputDay = date("Y-m-d");}

    // legg inn event i db
    if (isset($_POST["action"]) && $_POST["action"] == "saveEvent") {
        // family_id
        $sql = "SELECT id FROM families WHERE family_name = '".$_POST["sharedCalendar"]."';";
        $result = $conn -> query($sql);
        while($row = $result -> fetch_assoc()){
            $family_id = $row["id"];
    ***REMOVED***
        
        $startTime = $_POST["time"];
        $startHour = (int)substr($startTime, 0, 2);
        $startMinute = (int)substr($startTime, -2);

        $endTime = $_POST["endTime"];
        $endHour = (int)substr($endTime, 0, 2);
        $endMinute = (int)substr($endTime, -2);

        $duration = ($endHour - $startHour)*60 + $endMinute - $startMinute;
        if ($_POST["day"] == "") {$day = $inputDay;}
        else                     {$day = $_POST["day"];}
        $content = "\"".$_POST["title"] ."\",\"". $_POST["location"] ."\",\"$day\", $startHour, $startMinute, $duration";

        // hvis eventen er privat
        if (isset($_POST["private"])) {
            $sql = "INSERT INTO calendarEvents
                    (title, location, day, startHour, startMinute, duration, user_id, family_id, private)
                    VALUES ($content, $user_id, 0, TRUE);";
    ***REMOVED***
        // hvis er eventen skal på felleskalenderen
        else if (isset($_POST["sharedCalendar"])) {
            $sql = "INSERT INTO calendarEvents
                    (title, location, day, startHour, startMinute, duration, user_id, family_id, private)
                    VALUES ($content, 0, $family_id, FALSE);";
    ***REMOVED***
        // ellers er eventen public
        else {
            $sql = "INSERT INTO calendarEvents
                    (title, location, day, startHour, startMinute, duration, user_id, family_id, private)
                    VALUES ($content, $user_id, 0, FALSE);";
    ***REMOVED***

        $result = $conn -> query($sql);
***REMOVED***



    function getFamilies($conn, $user_id) {
        // brukernavnet er første kalender i arrayen
        $sql = "SELECT pseudonym FROM users WHERE id = $user_id;";
        $result = $conn -> query($sql);
        while($row = $result -> fetch_assoc()){
            $family = [$row["pseudonym"]];
    ***REMOVED***
        
        // navn på alle familiene som personen er med i
        $sql = "SELECT DISTINCT f.family_name, f.id
                FROM families f
                JOIN memberships m 
                ON f.id = m.family_id
                WHERE m.family_id IN
                (
                    SELECT m1.family_id
                    FROM memberships m1
                    WHERE m1.user_id = $user_id
                );";
        $result = $conn -> query($sql);
        while($row = $result -> fetch_assoc()){
            array_push($family, $row["family_name"]);
    ***REMOVED***
        
        return $family;
***REMOVED***
    


    function getEvents($conn, $user_id, $inputDay) {
        $events = [];
        // events fra personen
        $sql = "SELECT * FROM calendarEvents c
                JOIN users u
                ON c.user_id = u.id
                WHERE user_id = $user_id
                AND day = '$inputDay';";
        $result = $conn -> query($sql);
        while($row = $result -> fetch_assoc()){
            $affair = [
                "author"      => $row["pseudonym"],
                "title"       => $row["title"],
                "location"    => $row["location"],
                "day"         => $row["day"],
                "startHour"   => $row["startHour"],
                "startMinute" => $row["startMinute"], 
                "duration"    => $row["duration"]
            ];
            array_push($events, $affair);
    ***REMOVED***

        // felles events til familiene peronen er med i
        $sql = "SELECT * FROM calendarEvents e
                JOIN families f
                ON e.family_id = f.id
                WHERE family_id IN
                (
                    SELECT f1.id
                    FROM families f1
                    JOIN memberships m 
                    ON f1.id = m.family_id
                    WHERE m.family_id IN
                    (
                        SELECT m1.family_id
                        FROM memberships m1
                        WHERE m1.user_id = $user_id
                    )
                )
                AND day = '$inputDay';";
        $result = $conn -> query($sql);
        while($row = $result -> fetch_assoc()){
            $affair = [
                "author"      => $row["family_name"], // erstatt med navnet - må adde litt til queryen
                "title"       => $row["title"],
                "location"    => $row["location"],
                "day"         => $row["day"],
                "startHour"   => $row["startHour"],
                "startMinute" => $row["startMinute"], 
                "duration"    => $row["duration"]
            ];
            array_push($events, $affair);
    ***REMOVED***

        return $events;
***REMOVED***

    // privat og felleskalendere
    $family = getFamilies($conn, $user_id);
    $events = getEvents($conn, $user_id, $inputDay);
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Kalender - Dag</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css"  href="../css/day.css">
        <link rel="stylesheet" type="text/css"  href="../css/new.css">
        <link rel="stylesheet" type="text/css"  href="../css/visuals.css">
        <link rel="icon"       type="image/png" href="../visuals/logo.png">
    </head>
    <body>
        ***REMOVED*** include "../visuals/header.html";***REMOVED***

        <section id="map"></section>

        <form action="private.php"  method="post"   id="eventForm"> 
            <input  type="hidden"    name="action"   value="saveEvent">
            <input  type="text"      name="title"    placeholder="tittel">

            <input  type="text"      name="location" id="location">

            <label  for="day"> start</label>
            <input  type="date"      name="day"  id="day" value="***REMOVED*** echo $inputDay***REMOVED***">
            <input  type="time"      name="time" ***REMOVED*** if (isset($_GET["hrs"]) && isset($_GET["qrt"])) {echo "value=".substr("0".rtrim($_GET["hrs"], " ").":", -3).substr("0".$_GET["qrt"]*15, -2);}***REMOVED***>

            <label  for="endTime"> slutt</label>
            <input  type="time"      name="endTime"  id="endTime">

            <label  for="privat/public"> privat</label>
            <input  type="checkbox"  name="private"  id="privat/public">

            <select name="sharedCalendar" form="eventForm">
                <option disabled selected>felleskalender</option>
                ***REMOVED***
                    foreach (array_slice($family, 1) as $surename) {
                        echo "<option value=\"$surename\">$surename</option>";
                ***REMOVED***
               ***REMOVED***
            </select>

            <input  type="submit"    value="lagre">
        </form> 
            
        ***REMOVED***
            include "day.php"; 
            include "../visuals/footer.html";
       ***REMOVED***
        </main>
        
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL3SfCco316MoS6PdhzqjIg0vII5_vcyM&parameters" type="text/javascript"></script>
        <script type="text/javascript" src="../js/map.js"></script>
        <script type="text/javascript" src="../js/sidebar.js"></script>
    </body>
</html>

***REMOVED*** $conn -> close();***REMOVED***