***REMOVED***
    $user_id = 2;

    require "../db/dbConnect.php";

    // tidssone
    date_default_timezone_set("Europe/Oslo");

    // input måned
    if (isset($_GET["month"])) {$inputMonth = $_GET["month"];}
    else                       {$inputMonth = date("Y-m");}

    function getEvents($conn, $user_id, $inputMonth) {
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
    ***REMOVED***

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
                "author"      => $row["family_name"],
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

    // events fra db
    //$events = getEvents($conn, $user_id, $inputMonth); AND SUBSTRING av day i db = $inputMonth
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
        ***REMOVED***
            include "../visuals/header.html";
            include "month.php"; 
            include "../visuals/footer.html";
       ***REMOVED***
        <script type="text/javascript" src="../js/sidebar.js"></script>
        </main>
    </body>
</html>

***REMOVED*** $conn -> close();***REMOVED***