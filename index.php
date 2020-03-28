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

            </section>
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

            </section>
            <section class="weather">

            </section>
            <section class="family_members">

            </section>




        </main>
        <?php require 'visuals/footer.html' ?>
    </body>
</html>
