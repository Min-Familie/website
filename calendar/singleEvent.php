<?php
    $user_id = 1;
    require "../inc/db.inc.php";

    // slett event
    if (isset($_POST["delete"])) {
        $sql = "DELETE FROM calendarEvents
                WHERE id = ".$_POST["id"].";";
        $result = $con -> query($sql);
        header("Location: publicMonth.php");
    }

    // oppdater event
    else if (isset($_POST["action"]) && $_POST["action"] == "updateEvent") {
        $startTime = $_POST["startTime"];
        $startHour = (int)substr($startTime, 0, 2);
        $startMinute = (int)substr($startTime, -2);

        $endTime = $_POST["endTime"];
        $endHour = (int)substr($endTime, 0, 2);
        $endMinute = (int)substr($endTime, -2);

        $duration = ($endHour - $startHour)*60 + $endMinute - $startMinute;

        $title = $_POST["title"];
        $location = $_POST["location"];
        $day = $_POST["day"];

        $sql = "UPDATE calendarEvents
                SET title = '$title',
                    location = '$location',
                    day = '$day',
                    startHour = $startHour,
                    startMinute = $startMinute,
                    duration = $duration
                WHERE id = ".$_POST["id"].";";
        $result = $con -> query($sql);
    }

    // hvis ingen event er valgt
    if (!isset($_GET["event_id"]) || !isset($_GET["event_family_id"])) {
        header("Location: publicMonth.php");
    }

    $event_id = $_GET["event_id"];
    $event_family_id = $_GET["event_family_id"];


    // hvis fellesevent: if familie_id != 0
    if ($event_family_id) {
        $sql = "SELECT * FROM calendarEvents
                WHERE id = $event_id
                AND family_id IN
                (
                    SELECT f.id
                    FROM families f
                    JOIN memberships m
                    ON f.id = m.family_id
                    WHERE m.family_id IN
                    (
                        SELECT m1.family_id
                        FROM memberships m1
                        WHERE m1.user_id = $user_id
                    )
                )
                ;";
    }
    // ellers privat event
    else {
        $sql = "SELECT * FROM calendarEvents
                WHERE id = $event_id
                AND user_id = $user_id;";
    }

    $result = $con -> query($sql);
    while($row = $result -> fetch_assoc()){
        $event = [
            "title"       => $row["title"],
            "location"    => $row["location"],
            "day"         => $row["day"],
            "startHour"   => $row["startHour"],
            "startMinute" => $row["startMinute"],
            "duration"    => $row["duration"]
        ];
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Kalender - Dag</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css"  href="../css/new.css">
        <link rel="stylesheet" type="text/css"  href="../css/visuals.css">
        <link rel="icon"       type="image/png" href="../visuals/logo.png">
    </head>
    <body>
        <section>
        <?php
            include "../visuals/header.html";
            echo "<section id=\"map\"></section>";

            if (isset($event)) {
                $time0 = substr("0".$event["startHour"], -2).":".substr("0".$event["startMinute"], -2);
                $endH = $event["startHour"] + intdiv($event["duration"]+$event["startMinute"], 60);
                $endM = $event["startHour"]+$event["duration"] - intdiv($event["duration"]+$event["startMinute"], 60)*60;
                $endTime = substr("0$endH:", -3).substr("0$endM", -2);

                // info
                echo "<head>";
                echo "<h2>".$event["title"]."</h1>";
                echo "<h2>".$event["day"]."</h2>";
                echo "<h2>$time0 - $endTime</h2>";
                echo "</head>";

                // kart

                // rediger/slett
                echo   "<form action=\"singleEvent.php?event_id=$event_id&event_family_id=$event_family_id\"  method=\"post\"   id=\"eventForm\">
                            <input  type=\"hidden\"    name=\"action\"   value=\"updateEvent\">
                            <input  type=\"hidden\"     name=\"id\" value=$event_id>

                            <input  type=\"text\"      name=\"title\"    value=\"".$event["title"]."\">
                            <input  type=\"text\"      name=\"location\" id=\"location\" value=\"".$event["location"]."\">

                            <label  for=\"day\"> start</label>
                            <input  type=\"date\"      name=\"day\"  id=\"day\" value=\"".$event["day"]."\">
                            <input  type=\"time\"      name=\"startTime\" value=\"" . substr("0".$event["startHour"], -2).":".substr("0".$event["startMinute"], -2) . "\">

                            <label  for=\"endTime\"> slutt</label>
                            <input  type=\"time\"      name=\"endTime\"  id=\"endTime\" value=\"$endTime\">


                            <input  type=\"submit\"    value=\"ENDRE\">
                            <input  type=\"submit\"    name=\"delete\" value=\"SLETT '".$event["title"]."'\">
                        </form>";
            }

            else {
                echo "<p>Du har ikke tilgang til å redigere denne eventen.</p>";
            }
            echo "</section>";
            include "../visuals/footer.html";
        ?>




        <script type="text/javascript" src="../js/sidebar.js"></script>
        
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL3SfCco316MoS6PdhzqjIg0vII5_vcyM&parameters" type="text/javascript"></script>
        <script type="text/javascript" src="../js/map.js"></script>
        
        <script type="text/javascript">
        <?php $crd = explode(",", $event['location']); ?>
        var mapOptions = {
            zoom: 14,
            center: {lat: <?php echo $crd[0]; ?>, lng: <?php echo $crd[1]; ?>},
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: true
        };
        var pos = {
            coords: {
                latitude: mapOptions.center.lat,
                longitude: mapOptions.center.lng
            }
        };
        success(pos);
        </script>
    </body>
</html>

<?php $con -> close(); ?>