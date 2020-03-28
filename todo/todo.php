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
        <?php
        $user = $_GET['user'];
        $family = $_GET['family'];

        ?>
        <form id="nyItemForm" onsubmit="return false">
          <input type="text" id="nyItem" placeholder="E.g. Støvsuge huset...">
          <button type="button" id="nyButton" name="button" onclick="if(checkEmpty()){onClick();}">Legg til</button>
          <input type="hidden" id="user" value="<?php echo $user; ?>">
          <input type="hidden" id="family" value="<?php echo $family; ?>">
        </form>
        <p id="errorMessage"></p>
      </section>
      <section class="items">
      <ul>
        <?php
        include '../inc/showTodo.inc.php';
        ?>
      </ul>
      </section>
      </main>
      <?php
        include '../visuals/footer.html';
       ?>
  </body>
</html>
