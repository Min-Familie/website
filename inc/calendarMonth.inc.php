<?php
    function displayEvent($events, $date) {
        echo "<ul>";
        foreach($events as $key => $affair) {
            if($affair["day"] == $date) {
                echo "<li><a class=\"event\" href='singleEvent.php?event_id=".$affair["id"]."&event_family_id=".$affair["family_id"]."' >".substr("0".$affair["startHour"], -2).":".substr("0".$affair["startMinute"], -2)." ".$affair["title"]."</a></li>";
            }
            unset($events[$key]);
        }
        echo "</ul>";
    }

    // tiden nå
    $now = date("Y-m-d");

    // antall dager i denne og den forrige måneden
    $nDays     = date('t', strtotime($yearMonth));
    $nDaysPrev = date('t', strtotime($prevMonth));

    // hvilken ukedag er dag 1 i måneden
    $getdate = getdate(mktime(null, null, null, $month, 1, $year));
    $firstDayOfMonth = $getdate["weekday"];
    // hvilket nr. er denne dagen i uka
    $weakDays = array("Monday","Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $firstSquare = array_search($firstDayOfMonth, $weakDays);

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
?>


<table id="calendarMonth">
    <caption>
        <a href="publicMonth.php?month=<?php echo $prevMonth; ?>"> <</a>
        <a href="publicMonth.php"> i dag</a>
        <a href="publicMonth.php?month=<?php echo $nextMonth; ?>"> ></a>
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
                    $date = $prevMonth."-".substr("0".(string)$weekday, -2);
                    // hvis datoen er i dag
                    if ($date == $now) {
                        echo "<td class=\"today\">
                              <a href=\"publicDay.php?day=$date\">$weekday</a>";
                        displayEvent($events, $date);
                        echo "</td>";
                    }
                    // ellers hvis datoen er fra fortiden
                    else if ($date < $now) {
                        echo "<td class=\"past\">
                              <a href=\"publicDay.php?day=$date\">$weekday</a>";
                        displayEvent($events, $date);
                        echo "</td>";
                    }
                    // ellers så er datoen fra fremtiden
                    else {
                        echo "<td class=\"future\">
                              <a href=\"publicDay.php?day=$date\">$weekday</a>";
                        displayEvent($events, $date);
                        echo "</td>";
                    }
                }

                // første linje av måneden
                for ($i = 1; $i <= 7-$firstSquare; $i++) {
                    $date = $inputMonth."-".substr("0".(string)$i, -2);
                    if ($date == $now) {
                        echo "<td class=\"today\">
                              <a href=\"publicDay.php?day=$date\">$i</a>";
                        displayEvent($events, $date);
                        echo "</td>";
                    }
                    else if ($date < $now) {
                        echo "<td class=\"past\">
                              <a href=\"publicDay.php?day=$date\">$i</a>";
                        displayEvent($events, $date);
                        echo "</td>";
                    }
                    else {
                        echo "<td class=\"future\">
                              <a href=\"publicDay.php?day=$date\">$i</a> ";
                        displayEvent($events, $date);
                        echo "</td>";
                    }
                }
            ?>
        </tr>

        <tr>
            <?php
                // resten av måneden
                for ($j=$i, $weekday=1; $j<=$nDays; $j++, $weekday++) {
                    $date = $inputMonth."-".substr("0".(string)$j, -2);
                    if ($date == $now) {
                        echo "<td class=\"today\">
                              <a href=\"publicDay.php?day=$date\">$j</a>";
                        displayEvent($events, $date);
                        echo "</td>";
                    }
                    else if ($date < $now) {
                        echo "<td class=\"past\">
                              <a href=\"publicDay.php?day=$date\">$j</a>";
                        displayEvent($events, $date);
                        echo "</td>";
                    }
                    else {
                        echo "<td class=\"future\">
                              <a href=\"publicDay.php?day=$date\">$j</a>";
                        displayEvent($events, $date);
                        echo "</td>";
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
                        $date = $nextMonth."-".substr("0".(string)$i, -2);
                        if ($date == $now) {
                            echo "<td class=\"today\">
                                  <a href=\"publicDay.php?day=$date\">$i</a>";
                            displayEvent($events, $date);
                            echo "</td>";
                        }
                        else if ($date < $now) {
                            echo "<td class=\"past\">
                                  <a href=\"publicDay.php?day=$date\">$i</a>";
                            displayEvent($events, $date);
                            echo "</td>";
                        }
                        else {
                            echo "<td class=\"future\">
                                  <a href=\"publicDay.php?day=$date\">$i</a>";
                            displayEvent($events, $date);
                            echo "</td>";
                        }
                    }
                }
            ?>
        </tr>

    </tbody>
</table>
