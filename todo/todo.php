<?php
    include '../inc/db.inc.php';
    
    $user = $_GET['user'];
    $family = $_GET['family'];

    function getFamilies($con, $user, $family) {
        $families = [];

        // navn på alle familiene+id som personen er med i
        $sql = "SELECT DISTINCT
                IF($family=f.id, 'denne familien', f.family_name) AS family_name, f.id
                FROM families f
                JOIN memberships m
                ON f.id = m.family_id
                WHERE m.family_id IN
                (
                    SELECT m1.family_id
                    FROM memberships m1
                    WHERE m1.user_id = $user
                );";
        
        $result = $con -> query($sql);
        while($row = $result -> fetch_assoc()){
            array_push($families, [$row["family_name"], $row["id"]]);
        }

        return $families;
    }

    $families = getFamilies($con, $user, $family);
?>










<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/todo.css">
        <link rel="stylesheet" href="../css/visuals.css">
        <title>Todo</title>
    </head>
    <body>
        <script src="../js/todo.js"></script>
        <script src="../js/checkmark.js"></script>
        <script src="../js/checkempty.js"></script>
        <script src="../js/sidebar.js">

        </script>
        <?php include '../visuals/header.html'; ?>
        <main>
        <section class="leggInn">
            <h1>HUSKELISTE</h1>
            <!-- <section role="status" aria-live="polite">
            </section> -->

            <form id="nyItemForm" onsubmit="return false">
                <input type="text" id="nyItem" placeholder="E.g. Støvsuge huset...">
                <select class="permission">
                    <option value="private">Privat</option>
                    <?php
                        foreach ($families as $surename) { //surename=[navn, id]
                            echo "<option value=\"$surename[1]\">$surename[0]</option>";
                        }
                    ?>
                </select>
                <button type="button" id="nyButton" name="button" onclick="if(checkEmpty()){onClick();}">Legg til</button>
                <input type="hidden" id="user" value="<?php echo $user; ?>">
            </form>
            <p id="errorMessage"></p>
        </section>
        <section class="items">
        <ul>
            <?php include '../inc/showTodo.inc.php'; ?>
        </ul>
        </section>
        </main>
        <?php include '../visuals/footer.html'; ?>
    </body>
</html>

<?php $con->close(); ?>

