<?php
    session_start();
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
    }
    else {
        header("Location: ../login.html");
        //$user_id = 1;
    }

    require $_SERVER['DOCUMENT_ROOT'] . '/minfamilie/inc/db.inc.php';

    // tidssone
    date_default_timezone_set("Europe/Oslo");

    // input måned
    if (isset($_GET["month"])) {$inputMonth = $_GET["month"];}
    else                       {$inputMonth = date("Y-m");}
    // i forhold til inputMonth
    $month = date("m", strtotime($inputMonth));
    $year = date("Y", strtotime($inputMonth));
    $yearMonth = date("Y-m", strtotime($inputMonth));
    $nextMonth = date("Y-m", strtotime($inputMonth." +1 month"));
    $prevMonth = date("Y-m", strtotime($inputMonth." -1 month"));

    function getEvents($con, $user_id, $inputMonth, $prevMonth, $nextMonth) { // slå alle sammen og order by day
        $events = [];

        // private events fra personen
        $sql = "SELECT c.id, title, location, day, startHour, startMinute, duration, user_id, family_id, private, forename
                FROM calendarEvents c
                JOIN users u
                ON c.user_id = u.id
                WHERE user_id = $user_id
                AND private
                AND SUBSTRING(day, 1, 7) = '$inputMonth'
                OR  SUBSTRING(day, 1, 7) = '$prevMonth'
                OR  SUBSTRING(day, 1, 7) = '$nextMonth'


                UNION
                /*public events til alle familiemedlemmer i alle familier personen er med i*/
                SELECT c.id, title, location, day, startHour, startMinute, duration, user_id, family_id, private, forename
                FROM calendarEvents c
                JOIN users u
                ON c.user_id = u.id
                WHERE c.user_id in
                (
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
                AND SUBSTRING(day, 1, 7) = '$inputMonth'
                OR  SUBSTRING(day, 1, 7) = '$prevMonth'
                OR  SUBSTRING(day, 1, 7) = '$nextMonth'


                UNION
                /*felles events til familiene peronen er med i*/
                SELECT c.id, title, location, day, startHour, startMinute, duration, user_id, family_id, private, family_name AS forename
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
                AND SUBSTRING(day, 1, 7) = '$inputMonth'
                OR  SUBSTRING(day, 1, 7) = '$prevMonth'
                OR  SUBSTRING(day, 1, 7) = '$nextMonth'

                ORDER BY day, startHour, startMinute;";

        $result = $con -> query($sql);

        while ($row = $result -> fetch_assoc()) {
            $affair = [
                "author"      => $row["forename"],
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
    $events = getEvents($con, $user_id, $inputMonth, $prevMonth, $nextMonth);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Kalender - Dag</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css"  href="../css/calendarMonth.css">
        <link rel="stylesheet" type="text/css"  href="../css/visuals.css">
        <link rel="icon"       type="image/png" href="../visuals/logo.png">
    </head>
    <body>
        <?php
            include "../visuals/header.php";
            echo "<main>";
            require "../inc/calendarMonth.inc.php";
            echo "</main>";
            include "../visuals/footer.html";
        ?>
    </body>
</html>
