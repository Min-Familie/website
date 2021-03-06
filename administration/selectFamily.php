<?php
    session_start();
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
    }
    else {
        header("Location: ../login.html");
        //$user_id = 1;
    }

    require $_SERVER["DOCUMENT_ROOT"] . "/minfamilie/inc/db.inc.php";



    function getFamilies ($con, $user_id) {
        $families = [];

        // navn på alle familiene som personen er med i
        $sql = "SELECT DISTINCT f.family_name, f.id
                FROM families f
                JOIN memberships m
                ON f.id = m.family_id
                WHERE m.family_id IN
                (
                    SELECT m1.family_id
                    FROM memberships m1
                    WHERE m1.user_id = $user_id
                )";

        $result = $con -> query($sql);
        while($row = $result -> fetch_assoc()){
            array_push($families, [$row["id"], $row["family_name"]]);
        }
        return $families;
    }

    $families = getFamilies($con, $user_id);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Velg familie</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css"  href="../css/administrating.css">
        <link rel="stylesheet" type="text/css"  href="../css/visuals.css">
        <link rel="icon"       type="image/png" href="../visuals/logo.png">
    </head>
    <body>
        <?php
            include "../visuals/header.php";
            echo "<main>";

            if (isset($_GET["message"])) {
                echo "<p>".$_GET["message"]."</p>";
            }
        ?>

        <!-- Ny familie -->
        <form action="memberships.php" method="post" id="newFamilyForm">
            <h2>Stift en ny familie</h2>
            <input type="hidden" name="action"      value="newFamily">
            <input type="hidden" name="adminUserId" value="<?php echo $user_id ?>">
            <input type="text"   name="familyName"  placeholder="Familienavn">
            <input type="submit" value="Opprett">
        </form>

        <!-- Velg en gammel familie -->
        <h2 id="familiesListHeader">Velg en gammel familie</h2>
        <?php
            echo "<ul id=\"familiesList\">";
            foreach ($families as $family) {
                echo "<li> <a href=\"memberships.php?family_id=".$family[0]."\">".$family[1]."</a></li>";
            }
            echo "</ul>";
            echo "</main>";
            include "../visuals/footer.html";
        ?>
    </body>
</html>
