<?php
    // tidssone
    date_default_timezone_set("Europe/Oslo");

    // input dag
    if (isset($_GET["day"])) {$inputDay = $_GET["day"];}
    else                     {$inputDay = date("Y-m-d");}

    function getFamily($con, $user) {
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
                    WHERE m1.user_id = $user
                )



                UNION
                /*alle familiemedldmmer i alle familier som personen er med i*/
                SELECT DISTINCT u.forename, u.id
                FROM users u
                JOIN memberships m
                ON u.id = m.user_id
                WHERE m.family_id IN
                (
                    SELECT m1.family_id
                    FROM memberships m1
                    WHERE m1.user_id = $user
                )";
        $result = $con -> query($sql);
        while($row = $result -> fetch_assoc()){
            array_push($family, $row["family_name"]);
        }
        return $family;
    }

    function getEvents($con, $user, $inputDay) {
        $events = [];

        // private events fra personen
        $sql = "SELECT c.id, title, location, day, startHour, startMinute, duration, user_id, family_id, private, forename
                FROM calendarEvents c
                JOIN users u
                ON c.user_id = u.id
                WHERE user_id = $user
                AND private
                AND day = '$inputDay'



                UNION
                /*public events til alle familiemedlemmer i alle familier personen er med i*/
                SELECT c.id, title, location, day, startHour, startMinute, duration, user_id, family_id, private, forename
                FROM calendarEvents c
                JOIN users u /*for å få navn, og ikke bare id fra calendar-tabellen*/
                ON c.user_id = u.id
                WHERE c.user_id in
                    ( /*personene som er med i alle disse familiene*/
                    SELECT u.id
                    FROM users u
                    JOIN memberships m
                    ON u.id = m.user_id
                    WHERE m.family_id IN
                    ( /*familiene personen er med i*/
                        SELECT m1.family_id
                        FROM memberships m1
                        WHERE m1.user_id = $user
                    )
                )
                AND NOT private /*filtrering*/
                AND day = '$inputDay'



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
                        WHERE m1.user_id = $user
                    )
                )
                AND day = '$inputDay'";

        $result = $con -> query($sql);

        while($row = $result -> fetch_assoc()){
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

    function main($con, $inputDay){
        $user = $_SESSION['id'];
        // familiemedlemmer fra db
        $family = getFamily($con, $user);
        // events fra db
        $events = getEvents($con, $user, $inputDay);
        require "calendarDay.inc.php";
    }

    main($con, $inputDay);
?>