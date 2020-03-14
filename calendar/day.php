<?php
    require "db/dbConnect.php";



    function getFamily($conn){
        $family = ["Felles"];
        $sql = ";";
        $result = $conn -> query($sql);
        while($row = $result -> fetch_assoc()){
            array_push($family, $row["username"]);
        }
        return $family;
    }
    

    
    function getEvents($conn){
        $sql = ";";
        
        $result = $conn -> query($sql);
        $events = [];
        while($row = $result -> fetch_assoc()){
            $affair = [
                "author"      => $row[""],
                "title"       => $row[""],
                "duration"    => $row[""],
                "startHour"   => $row[""],
                "startMinute" => $row[""], 
                "location"    => $row[""]
            ];
            array_push($events, $affair);
        }
        return $events;
    }   


    // familiemedlemmer fra db
    //$family = getFamily($conn);

    // events fra db
    //$events = getEvents($conn);

    $family = ["felles","test","yaikes"];
    $events = [
        [
            "author"      => "test",
            "title"       => "ja",
            "location"    => "stokkahagen 56",
            "startHour"   => 1,
            "startMinute" => 45,
            "duration"    => 90
        ],
        [
            "author"      => "test",
            "title"       => "ja",
            "location"    => "oslo",
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
        <link rel="icon"       type="image/png" href="favicon.png">
    </head>
    <body>
        <?php include "calendarDay.php"; ?>
    </body>
</html>