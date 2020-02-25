<?php //https://codepen.io/javiercf/pen/GviKy
    // input dag
    if (isset($_GET["day"])) {$inputDay = $_GET["day"];}
    else                     {$inputDay = date("Y-m-d");}

    // for bruk i linkene
    $nextDay = date('Y-m-d', strtotime($inputDay." +1 day"));
    $prevDay = date('Y-m-d', strtotime($inputDay." -1 day"));

    // familiemedlemmer fra db
    $family = array("Shayan", "Patrick", "Leif", "Aleksander", "Bendik", "Kiran");
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
                    for ($i=0; $i<=24; $i++) {
                        echo "<tr>";
                        echo "<td class=\"hour\" rowspan=\"4\">".substr("0$i:00", -5)."</td>";
                        for ($j=0; $j<sizeof($family); $j++) {
                            echo "<td></td>";
                        }
                        echo "</tr>";

                        for ($k=0; $k<=2; $k++) {
                            echo "<tr>";
                            for ($j=0; $j<sizeof($family); $j++) {
                                echo "<td></td>";
                            }
                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </body>
</html>