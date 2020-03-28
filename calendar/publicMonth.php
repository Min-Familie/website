<?php
    $user_id = 2;

    require "../inc/db.inc.php";

    // tidssone
    date_default_timezone_set("Europe/Oslo");

    // input måned
    if (isset($_GET["month"])) {$inputMonth = $_GET["month"];}
    else                       {$inputMonth = date("Y-m");}

    function getEvents($con, $user_id, $inputMonth) { // slå alle sammen og order by day
        $events = [];

        // private events fra personen
        $sql = "SELECT * FROM calendarEvents c
                JOIN users u
                ON c.user_id = u.id
                WHERE user_id = $user_id
                AND private
                AND SUBSTRING(day, 1, 7) = '$inputMonth';";

        $result = $con -> query($sql);
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

        // public events til alle familiemedlemmer i alle familier personen er med i
        $sql = "SELECT * FROM calendarEvents c
                JOIN users u
                ON c.user_id = u.id
                WHERE c.user_id in (
                    SELECT u.id
                    FROM users u
                    JOIN memberships m
                    ON u.id = m.user_id
                    WHERE m.family_id IN
                    (
                        SELECT m1.family_id
                        FROM memberships m1
                        WHERE m1.user_id = $user_id
                    )
                )
                AND NOT private
                AND SUBSTRING(day, 1, 7) = '$inputMonth';";

        $result = $con -> query($sql);
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
                AND SUBSTRING(day, 1, 7) = '$inputMonth';";

        $result = $con -> query($sql);
        while($row = $result -> fetch_assoc()){
            $affair = [
                "author"      => $row["family_name"],
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

    // events fra db
    $events = getEvents($con, $user_id, $inputMonth);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Kalender - Dag</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css"  href="../css/month.css">
        <link rel="stylesheet" type="text/css"  href="../css/visuals.css">
        <link rel="icon"       type="image/png" href="../visuals/logo.png">
    </head>
    <body>
        <?php
            include "../visuals/header.html";
            include "month.php";
            include "../visuals/footer.html";
        ?>
        <script type="text/javascript" src="../js/sidebar.js"></script>
        </section>
    </body>
</html>

<?php $con -> close(); ?>
