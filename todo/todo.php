<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/todo.css">
    <title>Todo</title>
  </head>
  <body>
    <script src="../js/todo.js"></script>
    <main>
    <section class="leggInn">
        <h1>HUSKELISTE</h1>
        <!-- <section role="status" aria-live="polite">

        </section> -->
        ***REMOVED***
        $userID = $_GET['user'];
        $familyID = $_GET['family'];

       ***REMOVED***
        <form id="nyItemForm" onsubmit="return false">
          <input type="text" id="nyItem" placeholder="E.g. Støvsuge huset...">
          <button type="button" id="nyButton" name="button" onclick="onClick();">Legg til</button>
          <input type="hidden" id="user" value="***REMOVED*** echo $userID;***REMOVED***">
          <input type="hidden" id="family" value="***REMOVED*** echo $familyID;***REMOVED***">
        </form>
        <p id="errorMessage"></p>
      </section>
      <section class="items">
      <ul>
        ***REMOVED***
        include '../inc/showTodo.inc.php';
       ***REMOVED***
      </ul>
      </section>
      </main>
  </body>
</html>
