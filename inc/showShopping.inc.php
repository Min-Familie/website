<?php
    function deleteShopping($id, $con){
        $sql = "DELETE FROM shoppingItems WHERE id = $id";
        $result = $con -> query($sql);
    }


    function showShopping($con, $result)
    {
        while($row = $result -> fetch_assoc()){
            $id = $row['id'];
            $status = $row['status'];
            $time = $row['time'];
            if($status != 0){
                $check = "checked";
                // $style = "style = \"text-decoration:line-through\"";
                $class = "class=\"line_through\"";
            }
            else{
                $check = $style = $class = "";
            }
            if(isset($row['price']) && $row['price'] != 0){
                $price = "Totalt: " . round($row['price']) . " kr" . " | " . round($row['price']/$row['amount']) . " kr/stk";
            }
            else{
                $price = "Ikke oppgitt pris";
            }
            if ($time != null)
            {
                require 'time.inc.php';
                if($delete = timecheck($time)){
                    deleteShopping($id, $con);
                }
                else{
                    $delete = false;
                }
            }
            else{
              $delete = false;
            }
            if(!$delete){
                echo "<tr id=\"row$id\" $class>";
                echo "<td class=\"shoppingCell$id shoppingVare\" id=\"text$id\">" . $row['title'] . "</td>";
                echo "<td class=\"shoppingCell$id shoppingVare\">" . $row['amount'] . "</td>";
                echo "<td class=\"shoppingCell$id shoppingVare\">" . $price . "</td>";
                echo "<td class=\"shoppingVare\"><input type=\"checkbox\" autocomplete=\"off\" id=\"shopping$id\" $check onclick=\"check(this.id, $id, 'shopping', 'row$id');\"><button class=\"shoppingDelete\" onclick=\"delShopping($id);\">&#128465;</button></td>";
                echo "</tr>";
            }
        }
    }
    function mainShopping($con, $family){
        echo "<tr>
                <th>Vare</th>
                <th>Antall</th>
                <th>Pris*</th>
                <th>Endre status</th>
            </tr>";
        $sql = "SELECT id, time, title, amount, price, status FROM shoppingItems WHERE family_id = $family";
        $result = $con -> query($sql);
        if($result -> num_rows > 0){
            showShopping($con, $result);
        }
        else{
            echo "<tr><td id=\"empty\" colspan=\"4\">Ingen varer er lagt til.</td></tr>";
        }
        echo "<tr class=\"emptyRow\"><td colspan=\"4\"></td></tr>";
        echo "<tr class=\"emptyRow\"><td colspan=\"4\"></td></tr>";
        $sql = "SELECT ROUND(SUM(price)) AS sum FROM shoppingItems";
        $result = $con -> query($sql);
        while($row = $result -> fetch_assoc()){
            $total = $row['sum'];
        }
        echo "<tr class=\"sumShopping\"><td>Totalt:</td><td>$total kr</td></tr>";

    }
    $family_id = $_SESSION['family_id'];
    if ($family_id != 0){
        echo '<table id="varer">';
        mainShopping($con, $family_id);
        echo '</table>';
    }
    else{
        echo 'CREATE/JOIN A FAMILY FIRST';
    }

?>
