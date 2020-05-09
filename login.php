<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf-8">
        <meta name="google-signin-client_id"    content="280130080722-8ruhprpjaqt1vorhd8s245l9gtqgmr61.apps.googleusercontent.com">
        <link rel="stylesheet" type="text/css"  href="css/visuals.css">
        <link rel="stylesheet" type="text/css"  href="css/login.css">
        <link rel="icon"       type="image/png" href="visuals/logo.png">
    </head>
    <body>
        <?php include "visuals/header.php"; ?>
        <main>
            <div class="g-signin2" data-onsuccess="onSignIn"></div>
        </main>
        <?php include "visuals/footer.html"; ?>

        <script src="js/login.js"></script>
        <script src="https://apis.google.com/js/platform.js" async defer></script>
    </body>
</html>
