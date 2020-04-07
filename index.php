<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Dashboard</title>
        <link rel="stylesheet" href="css/master.css">
    </head>
    <body>
        <?php require 'visuals/header.html'; ?>
        <main>
            <?php

                $user = $_GET['user'];
                $family = $_GET['family'];
                require 'inc/db.inc.php';

             ?>

            <section class="calendar">
                <?php
                    require 'inc/dashboardCal.inc.php';
                 ?>
            </section>
            <?php
            $user = $_GET['user'];
            $family = $_GET['family'];
             ?>
            <section class="todo">
                <?php
                    require 'inc/showTodo.inc.php';
                 ?>
            </section>
            <section class="shopping">
                <?php
                    require 'inc/showShopping.inc.php';
                 ?>
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
