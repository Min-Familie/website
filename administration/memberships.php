<?php
    session_start();
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
    } // else er neders i denne php snippeten
    //else {$user_id = 1;}

    require $_SERVER["DOCUMENT_ROOT"] . "/minfamilie/inc/db.inc.php";



    // Forlate familie
    if (isset($_POST["action"]) && $_POST["action"] == "leave") {
        $family_id = $_POST["family_id"];
        $user_id = $_POST["user_id"];

        // hvis admin, slett hele familien
        $sql = "SELECT * FROM families
                WHERE id = $family_id
                AND administrator_user_id = $user_id";
        $result = $con -> query($sql);
        if (mysqli_num_rows($result) != 0) {
            $sql = "DELETE FROM families
                    WHERE id = $family_id";
            $result = $con -> query($sql);
            $sql = "DELETE FROM memberships
                    WHERE family_id = $family_id";
            $result = $con -> query($sql);
        }

        else {
            $sql = "DELETE FROM memberships
                    WHERE family_id = $family_id
                    AND user_id = $user_id";
            $result = $con -> query($sql);
        }
    }



    // Opprette ny familie
    if (isset($_POST["action"]) && $_POST["action"] == "newFamily") {
        $sql = "INSERT INTO families
                (family_name, administrator_user_id)
                VALUES (\"" . $_POST["familyName"] . "\"," . $_POST["adminUserId"] . ")";
        $result = $con -> query($sql);

        // familien sin id
        $sql = "SELECT id FROM families
                WHERE family_name = \"".$_POST["familyName"]."\"
                AND administrator_user_id = ".$_POST["adminUserId"]."
                ORDER BY id ASC";
        $result = $con -> query($sql);
        while($row = $result -> fetch_assoc()){
            $family_id = $row["id"];
            $_SESSION['family_id'] = $family_id;
        }

        // oppdatere memberships
        $sql = "INSERT INTO memberships
                (family_id, user_id)
                VALUES ($family_id, $user_id)";
        $result = $con -> query($sql);
    }



    // hvis familie_id fra GET
    if (isset($_GET["family_id"])) {
        $family_id = $_GET["family_id"];
        $_SESSION['family_id'] = $family_id;
    }
    // hvis den verken er i GET eller hvis familien er ny
    else if (!(isset($_POST["action"]) && $_POST["action"] == "newFamily")) {
        $noFamilyIsSelected = True;
    }



    // familiennavn
    if (isset($family_id)) {
        $sql = "SELECT family_name FROM families
                WHERE id = $family_id";

        $result = $con -> query($sql);
        while($row = $result -> fetch_assoc()){
            $family_name = $row["family_name"];
        }
    }



    // søk etter brukere
    if (isset($_POST["action"]) && $_POST["action"] == "userSearch") {
        $users = [];
        if (isset($_GET["sort"])) {
            $sort = isset($_GET["sort"]);
        } else {$sort = "id";}

        $search = $_POST["userSearch"];

        $sql = "SELECT * FROM users WHERE
                CONCAT(forename, ' ', surname)
                LIKE \"%$search"."%\"
                ORDER BY $sort";

        $result = $con -> query($sql);
        while($row = $result -> fetch_assoc()){
            array_push($users, [$row["id"], $row["forename"] ." ". $row["surname"]]);
        }
    }



    // Nytt familiemedlem
    if (isset($_POST["action"]) && $_POST["action"] == "addMember") {
        $family_id = $_POST["family_id"];
        $user = $_POST["user"];

        $sql = "INSERT INTO memberships
                (family_id, user_id)
                VALUES ($family_id, $user)";

        $result = $con -> query($sql);
    }



    // Sikkerhetssjekk: Er brukeren med i familien?
    if (isset($family_id)) {
        $sql = "SELECT * FROM memberships
                WHERE family_id = $family_id
                AND user_id = $user_id";
        $result = $con -> query($sql);
        $notMember = mysqli_num_rows($result) == 0;
    }



    function getFamily($con, $user_id, $family_id) {
        $family = [];
        $sql = "SELECT DISTINCT u.id, CONCAT(u.forename, ' ', u.surname) AS name
                FROM users u
                JOIN memberships m
                ON u.id = m.user_id
                WHERE m.family_id = $family_id";

        $result = $con -> query($sql);
        while($row = $result -> fetch_assoc()){
            $name = $row["name"];
            array_push($family, $name);
        }
        return $family;
    }

    $family = getFamily($con, $user_id, $family_id);

    $_SESSION["family_id"] = $family_id;



    // ut av siden?
    if (isset($_POST["action"]) && $_POST["action"] == "leave") {
        $headerMessage = "Du%20har%20forlatt%20familien.";
    }
    else if ($notMember) {
        $headerMessage = "Du%20er%20ikke%20medlem%20av%20familien.";
    }
    else if (isset($noFamilyIsSelected)) {
        $headerMessage = "Ingen%20familie%20er%20vaglt.";
    }

    if (isset($headerMessage)) {
        Header("Location: selectFamily.php?message=$headerMessage");
    }
    if (!isset($_SESSION['id'])) {
        Header("Location: login.html");
    }
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Administrer familien</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css"  href="../css/administrating.css">
        <link rel="stylesheet" type="text/css"  href="../css/visuals.css">
        <link rel="icon"       type="image/png" href="../visuals/logo.png">
    </head>
    <body>
        <?php
            include "../visuals/header.php";
            echo "<main>";
            echo "<h1>Familien $family_name</h1>";

            // Hvis admin
            $sql = "SELECT * FROM families
                    WHERE id = $family_id
                    AND administrator_user_id = $user_id";
            $result = $con -> query($sql);
            if (mysqli_num_rows($result) != 0) {
        ?>

                <!-- Legg til et medlem -->
                <!-- Søk etter brukere -->
                <form action="memberships.php?family_id=<?php echo $family_id ?>" method="post" id="searchForm">
                    <h2>Søk etter og til en bruker i familien</h2>
                    <input type="hidden" name="action" value="userSearch">
                    <input type="text"   name="userSearch"   placeholder="Søk etter brukernan eller navn">
                    <input type="submit" value="Søk">
                </form>

        <?php
                // søkeresultat
                if (isset($_POST["action"]) && $_POST["action"] == "userSearch") {
                    echo "<table id=\"searchResults\"><tr><th>Navn</th><th>Add</th></tr>";

                    foreach ($users as $user) {
                        echo "<tr><td>".$user[1]."</td>";
                        echo "<td>";
                        ?>
                        <form action="memberships.php?family_id=<?php echo $family_id ?>" method="post">
                            <input type="hidden" name="action" value="addMember">
                            <input type="hidden" name="user"   value="<?php echo $user[0] ?>">
                            <input type="hidden" name="family_id" value="<?php echo $family_id ?>">
                            <input type="submit" value="Legg til">
                        </form> </td></tr>
                        <?php
                    }
                    echo "</table>";
                }
            }
        ?>
        </fieldset>

        <h2 id="familiesListHeader">Familiemedlemmer</h2>
        <ul id="familiesList">
        <?php
            foreach ($family as $name) {
                echo "<li>$name</li>";
            }
        ?>
        </ul>

        <!-- Forlat familien -->
        <form action="memberships.php" method="post" id="leaveForm">
            <h2>Forlat Familien</h2>
            <input type="hidden" name="action"    value="leave">
            <input type="hidden" name="user_id"   value="<?php echo $user_id ?>">
            <input type="hidden" name="family_id" value="<?php echo $family_id ?>">
            <input type="submit" value="Forlat">
        </form>

        <?php
            echo "</main>";
            include "../visuals/footer.html";
        ?>
    </body>
</html>
