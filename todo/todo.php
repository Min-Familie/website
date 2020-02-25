<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Todo</title>
    <script src="../js/todo.js"></script>
  </head>
  <body>
    <section class="leggInn">
        <h1>Min huskeliste</h1>
        <form id="nyItemForm" onsubmit="return false">
          <input type="text" id="nyItem" placeholder="E.g. Støvsuge huset...">
          <button type="button" id="nyButton" name="button" onclick="onClick()">Button</button>
        </form>
        <p id="errorMessage"></p>
        <?php include '../inc/showTodo.inc.php'; ?>
    </section>
  </body>
</html>
