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
        <?php require 'visuals/header.html'; ?>
        <main>
            <?php

                $user = $_GET['user'];
                $family = $_GET['family'];
                require 'inc/db.inc.php';

             ?>

            <section class="calendar">
                <section class="calendarWrapper">
                    <?php
                        require 'inc/dashboardCal.inc.php';
                     ?>
                </section>
            </section>
            <?php
            $user = $_GET['user'];
            $family = $_GET['family'];
             ?>
            <section class="todo">
                <!-- <a class="todoDashboardTitle" href="todo/todo.php?user=<?php echo $user; ?>&family=<?php echo $family; ?>">Huskeliste</a> -->
                <?php
                    require 'inc/showTodo.inc.php';
                 ?>
                 <button class="todoLeggTil" type="button" name="button" onclick="location.href='todo/todo.php?user=<?php echo $user; ?>&family=<?php echo $family; ?>'">Legg til flere</button>
                 <!-- <a class="todoLink" href="todo/todo.php?user=<?php echo $user; ?>&family=<?php echo $family; ?>">
                 <section class="todoWrapper">
                     <p class="todoTextLink">Legg til flere</p>
                 </section>
                 </a> -->
            </section>
            <section class="shopping">

                <?php
                    require 'inc/showShopping.inc.php';
                 ?>
                 <button class="shoppingLeggTil" type="button" name="button" onclick="location.href='shopping/shopping.php?family=<?php echo $family; ?>'">Legg til flere</button>

            </section>
            <section class="news">
                <rssapp-wall id="DvxuYSPLia1qLCDF"></rssapp-wall><script src="https://widget.rss.app/v1/wall.js" type="text/javascript" async></script>

            </section>
            <section class="weather">
                <a class="weatherwidget-io" href="https://forecast7.com/en/58d855d73/sandnes/" data-label_1="SANDNES" data-label_2="WEATHER" data-icons="Climacons Animated" data-theme="original" >SANDNES WEATHER</a>
                    <script>
                    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
                    </script>
            </section>
            <section class="family_members">

            </section>




        </main>
        <?php require 'visuals/footer.html' ?>
    </body>
</html>
