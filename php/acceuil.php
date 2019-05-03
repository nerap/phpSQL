<?php
require 'functions.include.php';

session_start();

security();

$dataAccount = getAccountData();
foreach ($dataAccount as $key) {
  $dataOperation = getDateOperation((int)$key['id']);
}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Acceuil</title>
  </head>
  <body>
    <a href="formulaire.html" > <input type="button" name="" value="Creation"> </a>
    <br>
    <a href="choisir_compte.php" > <input type="button" name="" value="Edition Compte"> </a>
    <br>
    <a href="operation.php" > <input type="button" name="" value="Opération"> </a>
    <br>
    <a href="choisir_operation.php" > <input type="button" name="" value="Edition Opération"> </a>
    <form class="form_2" method="POST" action="index.php">
      <input type="submit" name="delete_account" value="Delete Account">
    </form>
    <table>
      <!--<?php
        foreach ($dataOperation as $compte) {
          echo '<tr>';
          echo '<td>' . $compte['nom_operation'] . '</td>';
         echo '<td>' . $compte['montant_operation'] . '</td>';
          echo '<td>' . $compte['date_operation'] . '</td>';
         echo '</tr>';
        }
      ?>-->
    </table>

  </body>
</html>
