<?php
    $user_id = 2;

    require "../db/dbConnect.php";

    // tidssone
    date_default_timezone_set("Europe/Oslo");
    
    // input dag
    if (isset($_GET["day"])) {$inputDay = $_GET["day"];}
    else                     {$inputDay = date("Y-m-d");}

    function getFamily($conn, $user_id) {
        $family = [];

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
        }

        // alle familiemedldmmer i alle familier som personen er med i
        $sql = "SELECT DISTINCT u.pseudonym, u.id
                FROM users u
                JOIN memberships m 
                ON u.id = m.user_id
                WHERE m.family_id IN
                (
                    SELECT m1.family_id
                    FROM memberships m1
                    WHERE m1.user_id = $user_id
                );";
        $result = $conn -> query($sql);
        while($row = $result -> fetch_assoc()){
            array_push($family, $row["pseudonym"]);
        }

        return $family;
    }
    
    function getEvents($conn, $user_id, $inputDay) {
        $events = [];

        // private events fra personen
        $sql = "SELECT * FROM calendarEvents c
                JOIN users u
                ON c.user_id = u.id
                WHERE user_id = $user_id
                AND private
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
        }

// public events til alle familiemedlemmer i alle familier personen er med i
$sql = "SELECT * FROM calendarEvents c
        JOIN users u -- for å få navn, og ikke bare id fra calendar-tabellen
        ON c.user_id = u.id
        WHERE c.user_id in
            ( -- personene som er med i alle disse familiene
            SELECT u.id
            FROM users u
            JOIN memberships m 
            ON u.id = m.user_id
            WHERE m.family_id IN
            ( -- familiene personen er med i
                SELECT m1.family_id
                FROM memberships m1
                WHERE m1.user_id = $user_id
            )
        )
        AND NOT private -- filtrering
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
        }
        
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
                "author"      => $row["family_name"],
                "title"       => $row["title"],
                "location"    => $row["location"],
                "day"         => $row["day"],
                "startHour"   => $row["startHour"],
                "startMinute" => $row["startMinute"], 
                "duration"    => $row["duration"]
            ];
            array_push($events, $affair);
        }

        return $events;
    }   


    // familiemedlemmer fra db
    $family = getFamily($conn, $user_id);
    // events fra db
    $events = getEvents($conn, $user_id, $inputDay);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Kalender - Dag</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css"  href="../css/day.css">
        <link rel="stylesheet" type="text/css"  href="../css/visuals.css">
        <link rel="icon"       type="image/png" href="../visuals/logo.png">
    </head>
    <body>
        <?php
            include "../visuals/header.html";
            include "day.php"; 
            include "../visuals/footer.html";
        ?>
        <script type="text/javascript" src="../js/sidebar.js"></script>
        </main>
    </body>
</html>

<?php $conn -> close(); ?>