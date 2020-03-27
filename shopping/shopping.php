<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Handleliste</title>
    <link rel="stylesheet" href="../css/shopping.css">
    <link rel="stylesheet" href="../css/visuals.css">
  </head>
  <body>
      <script src="../js/shopping.js"></script>
      <script src="../js/checkmark.js"></script>
      <script src="../js/checkempty.js"></script>
      <script src="../js/sidebar.js">
      <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
      <script type="text/javascript">
      $(document).ready(function() {
          $('#varer tr').click(function(event) {
              if (event.target.type !== 'checkbox') {
                  $(':checkbox', this).trigger('click');
              }

          });
      });
      </script>
    <main>
    <section class="form">
        <form id="nyItemForm" onsubmit="return false">
            <input type="text" name="item" placeholder="Varen din..." id="nyItem">
            <input type="number" name="amount" step="1" placeholder="Antall..." id="amount" required>
            <input type="number" name="price" placeholder="Pris (valgfritt)" id="price">
            <input type="hidden" name="family_id" value="<?php echo $_GET['family']; ?>" id="family_id">
            <button type="button" name="button" onclick="if(checkEmpty()){run();}">Legg til</button>
        </form>
        <p id="errorMessage"></p>
    </section>
    <section class="shopping">
        <table id="varer">
            <tr>
                <th>Vare</th>
                <th>Antall</th>
                <th>Pris*</th>
                <th>Kjøpt</th>
            </tr>
            <?php
            $family_id = $_GET['family'];
            include '../inc/showShopping.inc.php'; ?>
        </table>
    </section>
    </main>
    <?php
      include '../visuals/footer.html';
     ?>
  </body>
</html>
