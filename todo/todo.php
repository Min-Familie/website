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
        <!-- <section role="status" aria-live="polite">

        </section> -->
        <form id="nyItemForm" onsubmit="return false">
          <input type="text" id="nyItem" placeholder="E.g. Støvsuge huset...">
          <button type="button" id="nyButton" name="button" onclick="onClick()">Legg til</button>
        </form>
        <p id="errorMessage"></p>
        <ul style="list-style:none;padding-left:5px"><?php include '../inc/showTodo.inc.php'; ?></ul>
    </section>
  </body>
</html>
