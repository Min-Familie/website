<?php
    date_default_timezone_set("Europe/Oslo");
    if (!function_exists('timecheck')){
        function timecheck($time){
            $end = new DateTime($time);
            $now = new DateTime();
            $endTime = (int)($end -> modify("+1 day")) -> format("dmYHi");
            $nowTime = (int)($now -> format("dmYHi"));
            if($nowTime >= $endTime){
              return True;
            }
            else{
                return False;
            }
        }
    }
    $con->close();

 ?>
