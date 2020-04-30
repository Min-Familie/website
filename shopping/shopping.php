<?php 
    $family = 1; 
    require $_SERVER['DOCUMENT_ROOT'] . '/minfamilie/inc/db.inc.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Handleliste</title>
        <link rel="icon"       href="../visuals/logo.png" type="image/png">
        <link rel="stylesheet" href="../css/shopping.css">
        <link rel="stylesheet" href="../css/visuals.css">
    </head>
    <body>
        <script src="../js/shopping.js"></script>
        <script src="../js/checkmark.js"></script>
        <script src="../js/checkempty.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
        <script src="../js/shoppingCheck.js"></script>

        <?php include '../visuals/header.html'; ?>

        <main>

        <section class="form">
            <form id="nyItemForm" onsubmit="return false">
                <input type="text" name="item" placeholder="Varen din..." id="nyItem">
                <input type="number" name="amount" step="1" min="1" placeholder="Antall..." id="amount" value=1>
                <input type="number" name="price" min="0" placeholder="Pris (valgfritt)" id="price">
                <input type="hidden" name="family_id" value="<?php echo $family; ?>" id="family_id">
                <button type="button" name="button" onclick="if(checkEmpty()){run();}">Legg til</button>
            </form>
            <p id="errorMessage"></p>
        </section>
        <section class="shopping">

                <?php include '../inc/showShopping.inc.php'; ?>

        </section>
        </main>
        <?php include '../visuals/footer.html'; ?>
    </body>
</html>
