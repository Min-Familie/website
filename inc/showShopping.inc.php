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
            if(isset($row['price'])){
                $price = "Totalt: " . (int)$row['price'] * $row['amount'] . " kr" . " | " . $row['price'] . " kr/stk";
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
                echo "<td class=\"shoppingCell$id\" id=\"text$id\">" . $row['title'] . "</td>";
                echo "<td class=\"shoppingCell$id\">" . $row['amount'] . "</td>";
                echo "<td class=\"shoppingCell$id\">" . $price . "</td>";
                echo "<td><input type=\"checkbox\" autocomplete=\"off\" id=\"shopping$id\" $check onclick=\"check(this.id, $id, window.location, 'row$id');\"></td>";
                echo "</tr>";
            }
        }
    }
    function mainShopping($con, $family){
        echo "<tr>
                <th>Vare</th>
                <th>Antall</th>
                <th>Pris*</th>
                <th>Kjøpt</th>
            </tr>";
        $sql = "SELECT id, time, title, amount, price, status FROM shoppingItems WHERE family_id = $family";
        $result = $con -> query($sql);
        if($result -> num_rows > 0){
            showShopping($con, $result);
        }
        else{
            echo "<tr><td id=\"empty\" colspan=\"4\">Ingen varer er lagt til.</td></tr>";
        }
    }
    mainShopping($con, $family);

 ?>
