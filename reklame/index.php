<!DOCTYPE html>
<html>
    <head>
        <title>Reklame</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css"  href="../css/visuals.css">
        <link rel="icon"       type="image/png" href="../visuals/logo.png">
        <style>
            video {
                margin: 50px auto;
                height: 80%;
                max-width: 90%;
            }
            main {
	        display: flex;
	        align-items: center;
            	height: calc(100vh - 300px);
            }
            @media (max-width: 1100px) {
                main {
                    min-height: calc(100vh - 400px);
                }
            }
        </style>
    </head>
    <body>
        <?php include "../visuals/header.php"; ?>
        <main>
            <video controls>
                <source src="reklame.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </main>
        <?php include "../visuals/footer.html"; ?>
    </body>
</html>
