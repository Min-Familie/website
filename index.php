<?php
    require 'inc/db.inc.php';
    if (isset($_SESSION['id'])) {
        $user = $_SESSION['id'];
    }
    if (isset($_SESSION['family_id'])) {
        $family_id = $_SESSION['family_id'];
    }
    else{
        $family_id = 0;
    }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Dashboard</title>
        <link rel="stylesheet" href="css/master.css">
    </head>
    <body>
        <script src="js/checkmark.js"></script>
        <script src="js/todo.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
        <script src="js/shoppingCheck.js"></script>
        <?php require 'visuals/header.php'; ?>
        <main>
            <section class="todo">
                <?php
                    require 'inc/showTodo.inc.php';
                 ?>
                 <button class="todoLeggTil" type="button" name="button" onclick="location.href='todo/todo.php'">Legg til flere</button>
            </section>
            <section class="shopping">

                <?php
                if($family_id != 0){
                    require 'inc/showShopping.inc.php';
                    echo '<button class="shoppingLeggTil" type="button" name="button" onclick="location.href=\'shopping/shopping.php\'">Legg til flere</button>';
                }
                else{
                    echo '<h1 class="shoppingError">BLI MED ELLER LAG EN FAMILIE FOR Å FÅ TILGANG TIL HANDLELISTEN</h1>';
                }
                 ?>

            </section>
            <section class="weather">
                <a class="weatherwidget-io" href="https://forecast7.com/en/58d855d73/sandnes/" data-label_1="SANDNES" data-label_2="WEATHER" data-icons="Climacons Animated" data-theme="original" >SANDNES WEATHER</a>
                    <script>
                    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
                    </script>
            </section>
            <section class="news">
                <rssapp-wall id="DvxuYSPLia1qLCDF"></rssapp-wall><script src="https://widget.rss.app/v1/wall.js" type="text/javascript" async></script>

            </section>
            <section class="calendar">
                <section class="calendarWrapper">
                    <?php
                        require 'inc/dashboardCal.inc.php';
                     ?>
                </section>
            </section>


            <section class="family_members">

            </section>




        </main>
        <?php require 'visuals/footer.html' ?>
    </body>
</html>
