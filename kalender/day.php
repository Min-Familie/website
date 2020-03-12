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
        $earliest = $event1["tid"].".".$event1["tidmin"] < $event2["tid"].".".$event2["tidmin"];
        if ($earliest) {$tidmin = $event1["tidmin"];}
        else           {$tidmin = $event2["tidmin"];}
        
        // når slutter event1?
        $y1 = $event1["tid"];
        $y2 = intdiv($event1["tidmin"], 15);
        for ($i=0; $i<intdiv($event1["varighet"], 15); $i++) { // for hver celle eventen tar opp
            // neste klokkeslett
            $y2 ++;
            if ($y2==4) {$y1++; $y2=0;}
    ***REMOVED***
        $event1End = $y1.".".$y2 * 15;

        // når slutter event2?
        $y1 = $event2["tid"];
        $y2 = intdiv($event2["tidmin"], 15);
        for ($i=0; $i<intdiv($event2["varighet"], 15); $i++) { // for hver celle eventen tar opp
            // neste klokkeslett
            $y2 ++;
            if ($y2==4) {$y1++; $y2=0;}
    ***REMOVED***
        $event2End = $y1.".".$y2 * 15;

        // hvis event1 begynner og event1 slutter sist
        if      ($earliest && $event1End > $event2End)  {
            $pieces = explode(".", $event1End);
            $duration = $pieces[0]*60 + $pieces[1];
            $duration -= $tid*60 + $tidmin;
    ***REMOVED***
        // hvis event1 begynner og event2 slutter sist
        else if ($earliest && $event1End < $event2End)  {
            $pieces = explode(".", $event2End);
            $duration = $pieces[0]*60 + $pieces[1];
            $duration -= $tid*60 + $tidmin;
    ***REMOVED***
        // hvis event2 begynner og event1 slutter sist
        else if (!$earliest && $event1End > $event2End) {
            $pieces = explode(".", $event1End);
            $duration = $pieces[0]*60 + $pieces[1];
            $duration -= $event2["tid"]*60 + $event2["tidmin"];
    ***REMOVED***
        // event2 begynner og event2 slutter sist
        else                                            {
            $pieces = explode(".", $event2End);
            $duration = $pieces[0]*60 + $pieces[1];
            $duration -= $event2["tid"]*60 + $event2["tidmin"];
    ***REMOVED***
        
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


    /////////////////// MIDLERTIDIG \\\\\\\\\\\\\\\\\\\
    $family = array("Felles", "Shayan", "Patrick", "Leif", "Aleksander", "Bendik", "Kiran");
    $events = array( // sortert etter varigeht (lengste først), fordi kun en event kan starte samtidig
        array(
            "Author"    => "Patrick",
            "tid"         => 1, // 03:00
            "tidmin"      => 0, // 03:24
            "varighet"    => 60, // minutter
            "tittel"      => "jep",
            "sted"        => "59.952710, 10.909961"
        ),
        array(
            "Author"    => "Patrick",
            "tid"         => 2,
            "tidmin"      => 15,
            "varighet"    => 60,
            "tittel"      => "jha",
            "sted"        => "59.952710, 10.909961"
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
                            
                            $coords = array_map(function($i) {return $i[0];}, $occupied);
                            // hvis den allerede er der, slå sammen eventsene
                            if (in_array([$y1, $y2, $person], $coords)) {
                                $key = array_search([$y1, $y2, $person], $coords);
                                $event2 = $occupied[$key][1];

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
                                array_push($occupied, [[$y1, $y2, $person], $affair]);
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
    // kun koordinatene
    $occupied = array_map(function($i) {return $i[0];}, $occupied);
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
                                    if ([$hrs, $qrt, $person] == $coord) {
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