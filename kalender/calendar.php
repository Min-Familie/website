<?php
    date_default_timezone_set("Europe/Oslo");

    // input måned
    if (isset($_GET["month"])) {$inputMonth = $_GET["month"];}
    else                       {$inputMonth = date("Y-m");}

    // denne måneden?
    $currentMonth = $inputMonth == date("Y-m");
    // tidligere måned?
    $pastMonth = $inputMonth < date("Y-m");

    // tiden nå
    $day = date("d");
    $month = date("m", strtotime($inputMonth));
    $year = date("Y", strtotime($inputMonth));
    $yearMonth = date('Y-m', strtotime($inputMonth));
    $nextMonth = date('Y-m', strtotime($inputMonth." +1 month"));
    $prevMonth = date('Y-m', strtotime($inputMonth." -1 month"));

    $monthsText = array(
        "01" => "Januar", 
        "02" => "Februar",
        "03" => "Mars", 
        "04" => "April",
        "05" => "Mai",
        "06" => "Juni",
        "07" => "Juli", 
        "08" => "August", 
        "09" => "September",
        "10" => "Oktober", 
        "11" => "November",
        "12" => "Desember"
    );

    // antall dager i denne og den forrige måneden
    $nDays     = date('t', strtotime($yearMonth));
    $nDaysPrev = date('t', strtotime($prevMonth));

    // hvilken ukedag er dag 1 i måneden
    $getdate = getdate(mktime(null, null, null, $month, 1, $year));
    $firstDayOfMonth = $getdate["weekday"];
    // hvilket nr. er denne dagen i uka
    $weakDays = array("Monday","Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $firstSquare = array_search($firstDayOfMonth, $weakDays);
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Kalender - Måned</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css"  href="month.css">
        <link rel="icon"       type="image/png" href="favicon.png">
    </head>

    <body>
        <table>
            <caption> 
                <a href="calendar.php"> i dag</a>
                <a href="calendar.php?month=<?php echo $prevMonth; ?>"> <</a>
                <a href="calendar.php?month=<?php echo $nextMonth; ?>"> ></a>
                <?php echo $monthsText[$month] . " " . $year; ?> 
            </caption>
    
            <thead>
                <tr>
                    <th>M</th>
                    <th>T</th>
                    <th>O</th>
                    <th>T</th>
                    <th>F</th>
                    <th>L</th>
                    <th>S</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php //første linje
                        // slutten av forrige
                        for ($i = $firstSquare-1; $i >= 0; $i--) {
                            $weekday = $nDaysPrev-$i;
                            if ($pastMonth || $currentMonth) { // hvis denne eller en tidligere måned
                                echo "<td class=\"past\">   
                                      <a href=\"day.php?day=$prevMonth"."-"."$weekday\">$weekday</a> 
                                      </td>";
                            }
                            else {
                                echo "<td class=\"future\"> 
                                      <a href=\"day.php?day=$prevMonth"."-"."$weekday\">$weekday</a> 
                                      </td>";
                            }
                        }
                        
                        // første linje av måneden
                        for ($i = 1; $i <= 7-$firstSquare; $i++) {
                            if (($pastMonth) || ($i < $day && $currentMonth)) { // hvis en tidligere måned, eller en tidligere dag i måneden
                                echo "<td class=\"past\">   
                                      <a href=\"day.php?day=$inputMonth"."-"."$i\">$i</a> 
                                      </td>";
                            }
                            else if ($i == $day && $currentMonth) {
                                echo "<td class=\"today\"> 
                                      <a href=\"day.php?day=$inputMonth"."-"."$i\">$i</a> 
                                      </td>";
                            }
                            else {
                                echo "<td class=\"future\"> 
                                      <a href=\"day.php?day=$inputMonth"."-"."$i\">$i</a> 
                                      </td>";
                            }
                        }
                    ?>
                </tr>
                  
                <tr>
                    <?php
                        // resten av måneden
                        for ($j=$i, $weekday=1; $j<=$nDays; $j++, $weekday++) {
                            if (($pastMonth) || ($j < $day && $currentMonth)) { // hvis en tidligere måned, eller en tidligere dag i måneden
                                echo "<td class=\"past\">   
                                      <a href=\"day.php?day=$inputMonth"."-"."$j\">$j</a> 
                                      </td>";
                            }
                            else if ($j == $day && $currentMonth) {
                                echo "<td class=\"today\"> 
                                      <a href=\"day.php?day=$inputMonth"."-"."$j\">$j</a> 
                                      <ul> <li></li><li></li><li></li><li></li> </ul>
                                      </td>";
                            }
                            else {
                                echo "<td class=\"future\"> 
                                      <a href=\"day.php?day=$inputMonth"."-"."$j\">$j</a> 
                                      </td>";
                                }               
                          
                            // ny uke
                            if ($weekday == 7) {
                                echo "</tr><tr>";
                                $weekday = 0;
                            }
                        }    
            
                        // starten av neste måned
                        if ($weekday != 1) { // hvis ikke ny linje i kalenderen
                            for ($i = 1; $i <= 8-$weekday; $i++) {
                                if ($pastMonth) { // hvis en tidligere måned
                                    echo "<td class=\"past\">   
                                          <a href=\"day.php?day=$nextMonth"."-"."$i\">$i</a> 
                                          </td>";
                                }
                                else {
                                    echo "<td class=\"future\"> 
                                          <a href=\"day.php?day=$nextMonth"."-"."$i\">$i</a> 
                                          </td>";
                                }
                        }
                      }
                    ?>
                </tr>
                
            </tbody>
        </table>
          
    </body>
</html>