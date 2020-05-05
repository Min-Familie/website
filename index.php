<?php
    session_start();
    require 'inc/db.inc.php';
    if (isset($_SESSION['id'])) {
        $user = $_SESSION['id'];
    }
    else{
        header('Location: login.php');
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
        <link rel="alternate" type="application/rss+xml" title="Subscribe to What's New" href="https://www.nrk.no/toppsaker.rss" />
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
                <a class="weatherwidget-io" href="https://forecast7.com/no/58d975d73/stavanger/" data-label_1="STAVANGER" data-label_2="VÆR" data-theme="original" >STAVANGER VÆR</a>
                <script>
                !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
                </script>
                <a class="weatherwidget-io" href="https://forecast7.com/no/59d9110d75/oslo/" data-label_1="OSLO" data-label_2="VÆR" data-theme="original" >OSLO VÆR</a>
                <script>
                !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
                </script>
            </section>
            <section class="news">
                <?php
                    require 'rss/rss.php';
                    $feed = new Rss('https://www.nrk.no/toppsaker.rss');
                    $feed -> showFeed(4);
                 ?>
                <!-- <rssapp-wall id="DvxuYSPLia1qLCDF"></rssapp-wall><script src="https://widget.rss.app/v1/wall.js" type="text/javascript" async></script>
                <a href="https://www.nrk.no/toppsaker.rss" target="_blank">Subscribe to What's New</a> -->
            </section>
            <section class="calendar">
                <section class="calendarWrapper">
                    <?php
                        require 'inc/dashboardCal.inc.php';
                     ?>
                </section>
            </section>


            <section class="family_members">
                <?php
                    $user_id = $_SESSION['id'];
                    $sql = "SELECT DISTINCT u.picture_link
                            FROM users u
                            JOIN memberships m
                            ON u.id = m.user_id
                            WHERE m.family_id IN
                            (
                                SELECT m1.family_id
                                FROM memberships m1
                                WHERE m1.user_id = $user_id
                            )";
                    $result = $con -> query($sql);
                    while($row = $result -> fetch_assoc()){
                        $img = $row['picture_link'];

                        echo "<img src=\"$img\" alt=\"profile_picture\">";
                    }

                 ?>
            </section>




        </main>
        <?php require 'visuals/footer.html' ?>
    </body>
</html>
