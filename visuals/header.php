<head>
    <meta name="google-signin-client_id" content="280130080722-8ruhprpjaqt1vorhd8s245l9gtqgmr61.apps.googleusercontent.com">
</head>

<nav id="sidebar" class="sidebar">
    <a href="/minfamilie/index.php">Dashboard</a>
    <a href="/minfamilie/calendar/publicMonth.php">Kalender</a>
    <?php if (isset($_SESSION['family_id'])) {
        echo '<a href="/minfamilie/shopping/shopping.php">Handleliste</a>';
    } ?>
    <a href="/minfamilie/todo/todo.php">Gjøremål</a>
    <a href="/minfamilie/administration/selectFamily.php">Administrering</a>
    <a href="#" onclick="signOut();">Logg ut</a>
</nav>

<script type="text/javascript" src="/minfamilie/js/sidebar.js"></script>
<script src="js/login.js"></script>
<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>

<section id="main">
    <header>
        <button class="openbtn" onclick="openNav()">☰ Meny</button>
        <img src="/minfamilie/visuals/logo.png" alt="logo">
        <p> Min Familie</p>
        <p> Hele familiens knutepunkt!</p>

        <img id="profilepicture" src="
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/minfamilie/inc/db.inc.php';
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            $sql = "SELECT picture_link from users WHERE id = $id";
            if ($result = $con -> query($sql)) {
                while ($row = $result -> fetch_assoc()) {
                    echo $row['picture_link'];

                }
            }
        }

        else {
            echo 'https://cdn-images-1.medium.com/max/1200/1*MccriYX-ciBniUzRKAUsAw.png';
        }
         ?>
         " alt="picture">
    </header>
</section>
