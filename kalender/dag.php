<?php
    // input dag
    if (isset($_GET["day"])) {$inputDay = $_GET["day"];}
    else                     {$inputDay = date("Y-m-d");}

    // for bruk i linkene
    $nextDay = date('Y-m-d', strtotime($inputDay." +1 day"));
    $prevDay = date('Y-m-d', strtotime($inputDay." -1 day"));

    // familiemedlemmer fra db
    $family = array("Shayan", "Patrick", "Leif", "Aleksander", "Bendik", "Kiran");

    // events fra db
    $events = array( // sortert etter "kalender" og "tid"
        array(
            "kalender"    => "Patrick",
            "tid"         => 3, // 03:00
            "tidmin"      => 24, // 03:24
            "varighet"    => 78, // minutter
            "tittel"      => "jep",
            "sted"        => "59.952710, 10.909961", 
            "beskrivelse" => "besøk",
            "displayet"   => False
        )
    );
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
                        <a href="dag.php"> i dag</a>
                        <a href="dag.php?day=<?php echo $prevDay; ?>"> <</a>
                        <a href="dag.php?day=<?php echo $nextDay; ?>"> ></a>
                        <?php echo $inputDay; ?>
                    </th>
                    <?php
                        foreach ($family as $person){
                            echo "<th>$person</th>";
                        }
                    ?>
                </tr>  
            </thead>

            <tbody>
                <?php
                    for ($kl=0; $kl<=23; $kl++) { // for hver time
                        echo "<tr>";
                        echo "<td class=\"hour\" rowspan=\"4\">".substr("0$kl:00", -5)."</td>";

                        for ($min=0; $min<4; $min++) { // for hvert kvarter: fyll opp de 4 kolonne
                            if ($min!=0) {echo "<tr>";} // første gang er den allerede echoet
                            foreach ($family as $person) { // for hver row
                                // bytte ut "varighet" antall <td> med <td rowspan=\"$varighet\"></td>
                                // hvis ny event
                                if (!$events[0]["displayet"] && $events[0]["kalender"] == $person && $kl==$events[0]["tid"] && $min==intdiv($events[0]["tidmin"], 15)) {
                                    $varighet = intdiv($events[0]["varighet"], 15);
                                    echo "<td class=\"event\" rowspan=\"$varighet\">".$events[0]["tittel"]."</td>"; 
                                    $varighet -= 1;
                                    $events[0]["displayet"] = True;
                                } 

                                // hvis 
                                else if (isset($varighet) && $events[0]["kalender"]==$person && $varighet!=0) {$varighet-=1;}
                                
                                else {echo "<td></td>";} 
                            }
                            echo "</tr>";
                        }

                    }
                ?>
            </tbody>

        </table>

    </body>
</html>