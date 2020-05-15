<?php
    session_start();
    include '../inc/db.inc.php';
    if (isset($_SESSION['id'])) {
        $user = $_SESSION['id'];
    }
    else {
        header("Location: ../login.html");
    }
    if(isset($_SESSION['family_id'])){
        $family = $_SESSION['family_id'];
    }

    function getFamilies($con, $user, $family) {
        $families = [];

        // Navn på alle familiene+id som personen er med i
        $sql = "SELECT DISTINCT
                IF($family=f.id, 'Denne familien', f.family_name) AS family_name, f.id
                FROM families f
                JOIN memberships m
                ON f.id = m.family_id
                WHERE m.family_id IN
                (
                    SELECT m1.family_id
                    FROM memberships m1
                    WHERE m1.user_id = $user
                )";

        $result = $con -> query($sql);
        while($row = $result -> fetch_assoc()){
            array_push($families, [$row["family_name"], $row["id"]]);
        }

        return $families;
    }
    if(isset($_SESSION['family_id'])){
        $family_id = $_SESSION['family_id'];
    }
    else{
        $family_id = 0;
    }
    $families = getFamilies($con, $user, $family_id);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="icon"       href="../visuals/logo.png" type="image/png">
        <link rel="stylesheet" href="../css/todo.css">
        <link rel="stylesheet" href="../css/visuals.css">
        <title>Gjøremål</title>
    </head>
    <body class="todoBody">
        <script src="../js/todo.js"></script>
        <script src="../js/checkmark.js"></script>
        <script src="../js/checkempty.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

        </script>
            <?php include '../visuals/header.php'; ?>
        <main class="todoMain">
            <h1 class="todoTitle">GJØREMÅL</h1>
                <form id="nyItemForm" onsubmit="return false">
                    <input type="text" id="nyItem" placeholder="E.g. Støvsuge huset...">

                     <!-- Lager en select -->
                    <select id="permission" onchange="changeView(this.value, <?php echo $_SESSION['id']; ?>);">

                        <!-- Dersom en ikke har valg familie, vil "Privat" vises først, og så navnene til de ulike familiene -->
                        <?php if($family_id == 0){
                            echo '<option value=0>Privat</option>';
                            foreach ($families as $surname) {
                                echo "<option value=\"$surname[1]\">$surname[0]</option>";
                            }

                        }

                        // Ellers vil "Denne familien" vises først, og så de ulike familiene, og "Privat" til slutt
                        else{
                            $values = [];
                            foreach ($families as $surname) {
                                $values[$surname[0]] = $surname[1];
                            }
                            $dennefamilie = $values['Denne familien'];
                            echo "<option value=\"$dennefamilie\">Denne familien</option>";
                            foreach($values as $name => $val){
                                if($name != 'Denne familien'){
                                    echo "<option value=\"$val\">$name</option>";
                                }
                            }

                            echo '<option value=0>Privat</option>';
                        }?>
                    </select>
                    <button type="button" id="nyButton" name="button" onclick="if(checkEmpty()){onClick();}">Legg til</button>
                    <input type="hidden" id="user" value="<?php echo $user; ?>">
                </form>
                <p id="errorMessage"></p>
                <section id="items">

                    <?php include '../inc/showTodo.inc.php'; ?>

                </section>
        </main>
        <?php include '../visuals/footer.html'; ?>
    </body>
</html>
