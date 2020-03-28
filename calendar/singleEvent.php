<?php
    $user_id = 2;

    require "../db/dbConnect.php";

    // slett event
    if (isset($_POST["action"]) && $_POST["action"] == "delete") {
        $sql = "DELETE FROM calendarEvents
                WHERE id = ".$_POST["id"].";";
        $result = $conn -> query($sql);
    }

    // oppdater event
    if (isset($_POST["action"]) && $_POST["action"] == "updateEvent") {
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
        $result = $conn -> query($sql);
        echo $sql;
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

    $result = $conn -> query($sql);
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
        <link rel="stylesheet" type="text/css"  href="../css/singleEvent.css">
        <link rel="stylesheet" type="text/css"  href="../css/new.css">
        <link rel="stylesheet" type="text/css"  href="../css/visuals.css">
        <link rel="icon"       type="image/png" href="../visuals/logo.png">
    </head>
    <body>
        <?php
            include "../visuals/header.html";

            if (isset($event)) {
                // info
                echo "<h1>".$event["title"]."</h1>";
                echo "<h2>".$event["day"]."</h2>";
                echo "<h2>".substr("0".$event["startHour"], -2).":".substr("0".$event["startMinute"], -2)."</h2>";
                echo "<h2>".$event["duration"]." minutter</h2>";

                // kart

                // rediger
                $endTime = "10:00"; // regne ut
                echo   "<form action=\"singleEvent.php?event_id=$event_id&event_family_id=$event_family_id\"  method=\"post\"   id=\"eventForm\"> 
                            <input  type=\"hidden\"    name=\"action\"   value=\"updateEvent\">
                            <input type=\"hidden\" name=\"id\" value=$event_id>

                            <input  type=\"text\"      name=\"title\"    value=\"".$event["title"]."\">
                            <input  type=\"text\"      name=\"location\" id=\"location\" value=\"".$event["location"]."\">

                            <label  for=\"day\"> start</label>
                            <input  type=\"date\"      name=\"day\"  id=\"day\" value=\"".$event["day"]."\">
                            <input  type=\"time\"      name=\"startTime\" value=\"" . substr("0".$event["startHour"], -2).":".substr("0".$event["startMinute"], -2) . "\">

                            <label  for=\"endTime\"> slutt</label>
                            <input  type=\"time\"      name=\"endTime\"  id=\"endTime\" value=\"$endTime\">


                            <input  type=\"submit\"    value=\"endre\">
                        </form>";

                // slett
                echo   "<form action=\"singleEvent.php\" method=\"post\" >
                            <input type=\"hidden\" name=\"action\" value=\"delete\">
                            <input type=\"hidden\" name=\"id\" value=$event_id>
                            <input type=\"submit\" value=\"SLETT '".$event["title"]."'\">
                        </form>";
            }

            else {
                echo "<p>event finnes ikke i databasen</p>";
            }

            include "../visuals/footer.html";
        ?>

        <script type="text/javascript" src="../js/sidebar.js"></script>
        </section>
    </body>
</html>

<?php $conn -> close(); ?>