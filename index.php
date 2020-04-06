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

             ?>

            <section class="calendar">
                <!-- <?php
                    require 'inc/dashboardCal.inc.php';
                 ?> -->
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
                <iframe src="https://www.meteoblue.com/en/weather/widget/daily/liafossen_norway_9061542?geoloc=fixed&days=7&tempunit=CELSIUS&windunit=KILOMETER_PER_HOUR&precipunit=MILLIMETER&coloured=monochrome&pictoicon=0&pictoicon=1&maxtemperature=0&maxtemperature=1&mintemperature=0&mintemperature=1&windspeed=0&windgust=0&winddirection=0&uv=0&humidity=0&precipitation=0&precipitation=1&precipitationprobability=0&precipitationprobability=1&spot=0&pressure=0&layout=dark"  frameborder="0" scrolling="NO" allowtransparency="true" sandbox="allow-same-origin allow-scripts allow-popups allow-popups-to-escape-sandbox" style="width: 378px; height: 268px"></iframe><div><!-- DO NOT REMOVE THIS LINK --><a href="https://www.meteoblue.com/en/weather/week/liafossen_norway_9061542?utm_source=weather_widget&utm_medium=linkus&utm_content=daily&utm_campaign=Weather%2BWidget" target="_blank">meteoblue</a></div>
            </section>
            <section class="family_members">

            </section>




        </main>
        <?php require 'visuals/footer.html' ?>
    </body>
</html>
