***REMOVED***
    function getFamily($con){
        $family = array();
        $sql = "SELECT navn FROM familie";
        $result = $con -> query($sql);
        while($row = $result -> fetch_assoc()){
            array_push($family, $row['navn']);
    ***REMOVED***
        return $family;
***REMOVED***
    

    
    function getEvents($con){
        $sql = "SELECT familie.id, familie.navn, kalender.timer, kalender.min, kalender.varighet, kalender.tittel, kalender.sted, kalender.person
                FROM kalender
                LEFT JOIN familie
                ON kalender.person = familie.id";
        
        $result = $con -> query($sql);
        $events = array();
        while($row = $result -> fetch_assoc()){
            $event = array(
                "Author"      => $row['navn'],
                "tid"         => $row['timer'], // 03:00
                "tidmin"      => $row['min'], // 03:24
                "varighet"    => $row['varighet'], // minutter
                "tittel"      => $row['tittel'],
                "sted"        => $row['sted']
            );
            array_push($events, $event);
    ***REMOVED***
        return $events;
***REMOVED***



    function mergeEvets($event1, $event2) {
        $title = $event1["tittel"] . $event2["tittel"];
        $location = $event1["sted"] . $event2["sted"];
        $author = $event1["Author"];

        if ($event1["tid"] < $event2["tid"]) {$tid = $event1["tid"];}
        else                                 {$tid = $event2["tid"];}
        $earliest = $event1["tid"] < $event2["tid"] && $event1["tidmin"] < $event2["tidmin"];
        if ($earliest) {$tidmin = $event1["tidmin"];}
        else           {$tidmin = $event2["tidmin"];}

        // veldig midlertidig!!!
        $duration = $event1["varighet"] + $event2["varighet"];

        $event = array(
            "Author"      => $author,
            "tid"         => $tid,
            "tidmin"      => $tidmin,
            "varighet"    => $duration,
            "tittel"      => $title,
            "sted"        => $location,
        );
        return $event;
***REMOVED***



    function getEventOfCoords ($coord, $events, $family) {
        for ($hrs=0; $hrs<=23; $hrs++) { // for hver time
            for ($qrt=0; $qrt<4; $qrt++) { // for hvert kvarter
                foreach ($family as $person) { // for hver row => for hver celle

                    foreach ($events as $affair) {
                        $cells = [];
                        // hvis event starter
                        $now = $hrs==$affair["tid"] && $qrt==intdiv($affair["tidmin"], 15);
                        if ($affair["Author"]==$person && $now) {

                            $y1 = $hrs;
                            $y2 = $qrt;
                            for ($i=0; $i<intdiv($affair["varighet"], 15); $i++) { // for hver celle eventen tar opp

                                array_push($cells, [$y1, $y2, $person]);

                                // neste klokkeslett
                                $y2 ++;
                                if ($y2==4) {$y1++; $y2=0;}
                        ***REMOVED***

                    ***REMOVED***
                        if (in_array($coord, $cells)) {
                            return $affair;
                    ***REMOVED***
                ***REMOVED***

            ***REMOVED***
        ***REMOVED***
    ***REMOVED***
***REMOVED***
    
/*
    // familiemedlemmer fra db
    $family = getFamily($con);
    
    // events fra db
    $events = getEvents($con);
*/

    // tidssone
    date_default_timezone_set("Europe/Oslo");

    // input dag
    if (isset($_GET["day"])) {$inputDay = $_GET["day"];}
    else                     {$inputDay = date("Y-m-d");}

    // for bruk i linkene
    $nextDay = date('Y-m-d', strtotime($inputDay." +1 day"));
    $prevDay = date('Y-m-d', strtotime($inputDay." -1 day"));



    
    $family = array("Shayan", "Patrick", "Leif", "Aleksander", "Bendik", "Kiran");
    $events = array( // sortert etter varigeht (lengste først), fordi kun en event kan starte samtidig
        array(
            "Author"    => "Patrick",
            "tid"         => 3, // 03:00
            "tidmin"      => 0, // 03:24
            "varighet"    => 120, // minutter
            "tittel"      => "jep",
            "sted"        => "59.952710, 10.909961", 
            "beskrivelse" => "besøk"
        ),
        array(
            "Author"    => "Patrick",
            "tid"         => 2,
            "tidmin"      => 20,
            "varighet"    => 90,
            "tittel"      => "jha",
            "sted"        => "59.952710, 10.909961", 
            "beskrivelse" => "besøk"
        ),
        array(
            "Author"    => "Leif",
            "tid"         => 3,
            "tidmin"      => 0,
            "varighet"    => 90,
            "tittel"      => "ja",
            "sted"        => "59.952710, 10.909961", 
            "beskrivelse" => "besøk"
        )
    );

    // array med hvilke celler i koordinatform som er okkupert
    occupationTest:
    $occupied = [];

    for ($hrs=0; $hrs<=23; $hrs++) { // for hver time
        for ($qrt=0; $qrt<4; $qrt++) { // for hvert kvarter
            foreach ($family as $person) { // for hver row => for hver celle

                foreach ($events as $affair) {
                    // hvis event starter
                    $now = $hrs==$affair["tid"] && $qrt==intdiv($affair["tidmin"], 15);
                    if ($affair["Author"]==$person && $now) {
                        
                        $y1 = $hrs;
                        $y2 = $qrt;
                        for ($i=0; $i<intdiv($affair["varighet"], 15); $i++) { // for hver celle eventen tar opp
                            
                            // hvis den allerede er der, slå sammen eventsene
                            if (in_array([$y1, $y2, $person], $occupied)) {
                                // for hver time, kvarter. Hvis event starter, finn koordinatene den tar opp. Sjekk om koordinatet er der.
                                $event2 = getEventOfCoords([$y1, $y2, $person], $events, $family);
                                array_push($events, mergeEvets($affair, $event2));

                                // fjern $event2 og $affair fra events
                                $key = array_search($event2, $events); 
                                unset($events[$key]);
                                $key = array_search($affair, $events); 
                                unset($events[$key]);

                                // begyn på ny, fordi arrayen $events er endret
                                goto occupationTest; 
                        ***REMOVED***

                            // plass til event
                            else {
                                array_push($occupied, [$y1, $y2, $person]);
                        ***REMOVED***

                            // neste klokkeslett
                            $y2 ++;
                            if ($y2==4) {$y1++; $y2=0;}
                    ***REMOVED***

                ***REMOVED***
            ***REMOVED***

        ***REMOVED***
    ***REMOVED***
***REMOVED***
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Kalender - Dag</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css"  href="day.css">
        <link rel="icon"       type="image/png" href="favicon.png">
    </head>
    <body>

        <table>
            <thead>
                <tr>
                    <th>
                        <a href="day.php"> i dag</a>
                        <a href="day.php?day=***REMOVED*** echo $prevDay;***REMOVED***"> <</a>
                        <a href="day.php?day=***REMOVED*** echo $nextDay;***REMOVED***"> ></a>
                        ***REMOVED*** echo $inputDay;***REMOVED***
                    </th>
                    ***REMOVED***
                        foreach ($family as $person){
                            echo "<th>$person</th>";
                    ***REMOVED***
                   ***REMOVED***
                </tr>  
            </thead>

            <tbody>
                ***REMOVED***
                    for ($hrs=0; $hrs<=23; $hrs++) { // for hver time
                        echo "<tr>";
                        echo "<td class=\"hour\" rowspan=\"4\">".substr("0$hrs:00", -5)."</td>";

                        for ($qrt=0; $qrt<4; $qrt++) { // for hvert kvarter: fyll opp de 4 kolonne
                            if ($qrt!=0) {echo "<tr>";} // første gang er den allerede echoet

                            foreach ($family as $person) { // for hver row => for hver celle
                                $empty = ! in_array([$hrs, $qrt, $person], $occupied);
                                $empty = True;
                                foreach ($occupied as $coord) {
                                    if ([$hrs, $qrt, $person] == $coord) { // if ([$hrs, $qrt, $person] == $coord[0]) {
                                        $empty = False;
                                        break; // stopper å lete videre
                                ***REMOVED***
                            ***REMOVED***

                                if ($empty) {echo "<td></td>";} // hvis det ikke er en event i ruta
                                else { //ellers er det plass til en event
                                    foreach ($events as $affair) { // for hver event
                                        // hvis ny event
                                        $now = $hrs==$affair["tid"] && $qrt==intdiv($affair["tidmin"], 15);
                                        if ($affair["Author"]==$person && $now) {
                                            
                                            // hvis ruta ovenfor har event og den ikke er ferdig i den ruta: utsett start med 15 minutter, slik at den sjekker igjen neste gang. Ellers, gjør som vanlig:
                                            // har ruta ovenfor en event?
                                            $y1 = $hrs;
                                            $y2 = $qrt;
                                            if ($qrt==0) {$y1 --; $y2=3;} // forrige celle 
                                            else         {$y2 --;}
                                            $empty = True;
                                            foreach ($occupied as $coord) {
                                                if ([$y1, $y2, $person] == $coord) { //if ([$y1, $y2, $person] == $coord[0]) {
                                                    $empty = False;
                                                    break; // stopper å lete videre
                                            ***REMOVED***
                                        ***REMOVED***

                                            echo "<td class=\"event\" 
                                            rowspan=\"".intdiv($affair["varighet"], 15)."\"> </td>";

                                            break; // stopper å lete videre
                                    ***REMOVED***
                                ***REMOVED***
                            ***REMOVED***
                                
                        ***REMOVED***
                            echo "</tr>";

                    ***REMOVED***

                ***REMOVED***
               ***REMOVED***
            </tbody>

        </table>

    </body>
</html>