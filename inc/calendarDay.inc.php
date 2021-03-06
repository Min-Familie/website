<?php
    function mergeEvets($event1, $event2) {
        $title = $event1["title"] ." + ". $event2["title"];
        $location = $event1["location"] ." + ". $event2["location"];
        $author = $event1["author"];
        $id = $event1["id"];
        $family_id = $event1["family_id"];

        if ($event1["startHour"] < $event2["startHour"]) {$tid = $event1["startHour"];}
        else                                             {$tid = $event2["startHour"];}
        $earliest = $event1["startHour"].".".$event1["startMinute"] < $event2["startHour"].".".$event2["startMinute"];
        if ($earliest) {$tidmin = $event1["startMinute"];}
        else           {$tidmin = $event2["startMinute"];}

        // når slutter event1?
        $y1 = $event1["startHour"];
        $y2 = intdiv($event1["startMinute"], 15);
        for ($i=0; $i<intdiv($event1["duration"], 15); $i++) { // for hver celle eventen tar opp
            // neste klokkeslett
            $y2 ++;
            if ($y2==4) {$y1++; $y2=0;}
        }
        $event1End = $y1.".".$y2 * 15;

        // når slutter event2?
        $y1 = $event2["startHour"];
        $y2 = intdiv($event2["startMinute"], 15);
        for ($i=0; $i<intdiv($event2["duration"], 15); $i++) { // for hver celle eventen tar opp
            // neste klokkeslett
            $y2 ++;
            if ($y2==4) {$y1++; $y2=0;}
        }
        $event2End = $y1.".".$y2 * 15;

        // hvis event1 begynner og event1 slutter sist
        if      ($earliest && $event1End > $event2End)  {
            $pieces = explode(".", $event1End);
            $duration = $pieces[0]*60 + $pieces[1];
            $duration -= $tid*60 + $tidmin;
        }
        // hvis event1 begynner og event2 slutter sist
        else if ($earliest && $event1End < $event2End)  {
            $pieces = explode(".", $event2End);
            $duration = $pieces[0]*60 + $pieces[1];
            $duration -= $tid*60 + $tidmin;
        }
        // hvis event2 begynner og event1 slutter sist
        else if (!$earliest && $event1End > $event2End) {
            $pieces = explode(".", $event1End);
            $duration = $pieces[0]*60 + $pieces[1];
            $duration -= $event2["startHour"]*60 + $event2["startMinute"];
        }
        // event2 begynner og event2 slutter sist
        else                                            {
            $pieces = explode(".", $event2End);
            $duration = $pieces[0]*60 + $pieces[1];
            $duration -= $event2["startHour"]*60 + $event2["startMinute"];
        }

        $affair = [
            "author"      => $author,
            "title"       => $title,
            "location"    => $location,
            "startHour"   => $tid,
            "startMinute" => $tidmin,
            "duration"    => $duration,
            "id"          => $id,
            "family_id"   => $family_id
        ];
        return $affair;
    }

    // for bruk i linkene
    $nextDay = date('Y-m-d', strtotime($inputDay." +1 day"));
    $prevDay = date('Y-m-d', strtotime($inputDay." -1 day"));

    // array med hvilke celler i koordinatform som er okkupert
    occupationTest:
    $occupied = [];

    for ($hrs=0; $hrs<=23; $hrs++) { // for hver time
        for ($qrt=0; $qrt<4; $qrt++) { // for hvert kvarter
            foreach ($family as $person) { // for hver row => for hver celle

                foreach ($events as $affair) {
                    // hvis event starter
                    $now = $hrs==$affair["startHour"] && $qrt==intdiv($affair["startMinute"], 15);
                    if ($affair["author"]==$person && $now) {
                        
                        $y1 = $hrs;
                        $y2 = $qrt;
                        for ($i=0; $i<intdiv($affair["duration"], 15); $i++) { // for hver celle eventen tar opp
                            
                            $coords = array_map(function($i) {return $i[0];}, $occupied);
                            // hvis den allerede er der, slå sammen eventsene
                            if (in_array([$y1, $y2, $person], $coords)) {
                                // slå sammen events
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
                            }

                            // plass til event
                            else {
                                array_push($occupied, [[$y1, $y2, $person], $affair]);
                            }

                            // neste klokkeslett
                            $y2 ++;
                            if ($y2==4) {$y1++; $y2=0;}
                        }

                    }
                }

            }
        }
    }
    // kun koordinatene
    $occupied = array_map(function($i) {return $i[0];}, $occupied);
?>





<table id="calendarDay">
    <thead>
        <tr>
            <th id="calendarNav">
                <?php
                    if (basename($_SERVER["PHP_SELF"]) == "privateDay.php") {
                        ?>
                        <a href="publicDay.php?day=<?php echo $inputDay; ?>"> -</a>
                        <a href="privateDay.php?day=<?php echo $prevDay; ?>"> <</a>
                        <a href="privateDay.php"> i dag</a>
                        <a href="privateDay.php?day=<?php echo $nextDay; ?>"> ></a>
                        <?php
                        echo $inputDay;
                    }
                    else if (basename($_SERVER["PHP_SELF"]) == "publicDay.php"){
                        ?>
                        <a href="privateDay.php?day=<?php echo $inputDay; ?>"> +</a>
                        <a href="publicDay.php?day=<?php echo $prevDay; ?>"> <</a>
                        <a href="publicDay.php"> i dag</a>
                        <a href="publicDay.php?day=<?php echo $nextDay; ?>"> ></a>
                        <?php
                        echo $inputDay;
                    }
                    else { // dashboard
                        ?>
                        <a href="calendar/publicMonth.php"> Måned</a>
                        <a href="calendar/publicDay.php"> Dag</a>
                        <?php
                    }
                ?>
            </th>
            <?php
                foreach ($family as $username){
                    echo "<th>$username</th>";
                }
            ?>
        </tr>  
    </thead>

    <tbody>
        <?php
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
                            }
                        }

                        if ($empty) { // hvis det ikke er en event i ruta
                            if (basename($_SERVER["PHP_SELF"]) == "index.php") { //hvis dashboard 
                                echo "<td onclick=\"location.href='calendar/privateDay.php?day=$inputDay&hrs=$hrs&qrt=$qrt'\"> </td>";
                            }
                            else {
                                echo "<td onclick=\"location.href='privateDay.php?day=$inputDay&hrs=$hrs&qrt=$qrt'\"> </td>";
                            }
                        }
                        else { //ellers er det plass til en event
                            foreach ($events as $affair) { // for hver event
                                // hvis ny event 
                                $now = $hrs==$affair["startHour"] && $qrt==intdiv($affair["startMinute"], 15);
                                if ($affair["author"]==$person && $now) {

                                    $time0 = substr("0$hrs:", -3).substr("0".$affair["startMinute"], -2);
                                    $endH = $hrs + intdiv($affair["duration"]+$affair["startMinute"], 60);
                                    $endM = $hrs+$affair["duration"] - intdiv($affair["duration"]+$affair["startMinute"], 60)*60;
                                    $timeEnd = substr("0$endH:", -3).substr("0$endM", -2);

                                    if (basename($_SERVER["PHP_SELF"]) == "index.php") {
                                        echo "<td class=\"event\" rowspan=\"".intdiv($affair["duration"], 15)."\"
                                        onclick=\"location.href='calendar/singleEvent.php?event_id=".$affair["id"]."&event_family_id=".$affair["family_id"]."'\"> 
                                                <ul>
                                                    <li class=\"title\">".$affair["title"]."</li>
                                                    <li>$time0 - $timeEnd</li>";
                                    }
                                    else {
                                        echo "<td class=\"event\" rowspan=\"".intdiv($affair["duration"], 15)."\"
                                        onclick=\"location.href='singleEvent.php?event_id=".$affair["id"]."&event_family_id=".$affair["family_id"]."'\"> 
                                                <ul>
                                                    <li class=\"title\">".$affair["title"]."</li>
                                                    <li>$time0 - $timeEnd</li>";
                                    }

                                    if ($affair["duration"]>15) {
                                        echo   "<li><a href=\"https://www.google.com/maps/place/".$affair["location"]."\" target=\"_blank\">kart</a></li>"; 
                                    }
                                    
                                    echo       "</ul>
                                        </td>
                                    ";

                                    break; // stopper å lete videre
                                }
                            }
                        }
                        
                    }
                    echo "</tr>";

                }

            }
        ?>
    </tbody>
</table>
