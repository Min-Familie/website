<?php
    $user_id = 1;
    require "../db/dbConnect.php";

    // tidssone
    date_default_timezone_set("Europe/Oslo");

    // input dag
    if (isset($_GET["day"])) {$inputDay = $_GET["day"];}
    else                     {$inputDay = date("Y-m-d");}

    // legg inn event i db
    if (isset($_POST["action"]) && $_POST["action"] == "saveEvent" && $_POST["title"] != "") {
        $startTime = $_POST["time"];
        $startHour = (int)substr($startTime, 0, 2);
        $startMinute = (int)substr($startTime, -2);

        $endTime = $_POST["endTime"];
        $endHour = (int)substr($endTime, 0, 2);
        $endMinute = (int)substr($endTime, -2);

        $duration = ($endHour - $startHour)*60 + $endMinute - $startMinute;
        if ($duration<15) {$duration=15;}


        if ($_POST["day"] == "") {$day = $inputDay;}
        else                     {$day = $_POST["day"];}
        $content = "\"".$_POST["title"] ."\",\"". $_POST["location"] ."\",\"$day\", $startHour, $startMinute, $duration";

        // hvis eventen er privat
        if ($_POST["selectCalendar"] == "private") {
            $sql = "INSERT INTO calendarEvents
                    (title, location, day, startHour, startMinute, duration, user_id, family_id, private)
                    VALUES ($content, $user_id, 0, TRUE);";
        }
        // hvis er eventen public
        else if ($_POST["selectCalendar"] == "public") {
            $sql = "INSERT INTO calendarEvents
                    (title, location, day, startHour, startMinute, duration, user_id, family_id, private)
                    VALUES ($content, $user_id, 0, FALSE);";
        }
        // ellers tilhører den en familie
        else {
            $sql = "INSERT INTO calendarEvents
                    (title, location, day, startHour, startMinute, duration, user_id, family_id, private)
                    VALUES ($content, 0, ".$_POST["selectCalendar"].", FALSE);";
        }

        $result = $conn -> query($sql);
    }



    function getFamilies($conn, $user_id) {
        $family = [];
        // brukernavnet er første kalender i arrayen
        $sql = "SELECT pseudonym, id FROM users WHERE id = $user_id

                UNION
                -- navn på alle familiene som personen er med i
                SELECT DISTINCT f.family_name AS pseudonym, f.id
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
            array_push($family, [$row["pseudonym"], $row["id"]]); // [$row["pseudonym"], $row["id"]]
        }
        
        return $family; 
    }
    


    function getEvents($conn, $user_id, $inputDay) {
        $events = [];
        // events fra personen
        $sql = "SELECT c.id, title, location, day, startHour, startMinute, duration, user_id, family_id, private, pseudonym
                FROM calendarEvents c
                JOIN users u
                ON c.user_id = u.id
                WHERE user_id = $user_id
                AND day = '$inputDay'
                

                UNION
                -- felles events til familiene peronen er med i
                SELECT c.id, title, location, day, startHour, startMinute, duration, user_id, family_id, private, family_name AS pseudonym
                FROM calendarEvents c
                JOIN families f
                ON c.family_id = f.id
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
                "author"      => $row["pseudonym"], 
                "title"       => $row["title"],
                "location"    => $row["location"],
                "day"         => $row["day"],
                "startHour"   => $row["startHour"],
                "startMinute" => $row["startMinute"], 
                "duration"    => $row["duration"],
                "id"          => $row["id"],
                "family_id"   => $row["family_id"]
            ];
            array_push($events, $affair);
        }
        return $events;
    }

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
        <article>
        <?php include "../visuals/header.html"; ?>

        <section id="map"></section>

        <form action="private.php?day=<?php echo $inputDay;?>"  method="post"   id="eventForm"> 
            <input  type="hidden"    name="action"   value="saveEvent">
            <input  type="text"      name="title"    placeholder="tittel">

            <input  type="text"      name="location" id="location">

            <label  for="day"> start</label>
            <input  type="date"      name="day"  id="day" value="<?php echo $inputDay ?>">
            <input  type="time"      name="time" <?php if (isset($_GET["hrs"]) && isset($_GET["qrt"])) {echo "value=".substr("0".rtrim($_GET["hrs"], " ").":", -3).substr("0".$_GET["qrt"]*15, -2);} ?>>

            <label  for="endTime"> slutt</label>
            <input  type="time"      name="endTime"  id="endTime">

            <label  for="selectCalendar"> kalender</label>
            <select id="selectCalendar" name="selectCalendar" form="eventForm">
                <option value="public">synlig for familiemedlemmer</option>
                <option value="private">privat</option>
                <?php
                    foreach (array_slice($family, 1) as $surename) { //surename=[navn, id]
                        echo "<option value=\"$surename[1]\">$surename[0]</option>";
                    }
                ?>
            </select>

            <input  type="submit"    value="lagre">
        </form> 
            
        <?php
            // kun navenene
            $family = array_map(function($i) {return $i[0];}, $family);
            include "day.php"; 
            echo "</article>";
            include "../visuals/footer.html";
        ?>
        </section>
        
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL3SfCco316MoS6PdhzqjIg0vII5_vcyM&parameters" type="text/javascript"></script>
        <script type="text/javascript" src="../js/map.js"></script>
        <script type="text/javascript" src="../js/sidebar.js"></script>
    </body>
</html>

<?php $conn -> close(); ?>