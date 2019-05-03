<?php

require 'functions.include.php';

session_start();

security();

$dataAccount = getAccountData();
if (sizeof($dataAccount) == 0){
  header('Location: acceuil.php');
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Acceuil</title>
  </head>
  <body>
    <form class="form_1" method="POST" action="edition.php">
      <div>
      <label for="nom_compte">Nom du compte a modifier</label>
      <select name="idCompte">
        <?php
          foreach ($dataAccount as $compte) {
            echo '<option value="' . $compte['id'] . '">' . $compte['nom_compte'] . '(' . $compte['provision'] . ')</option>';
          }
        ?>
      </select>
      <input type="submit" name="selectAccount" value="Choisir">
    </div>
    </form>
    <a href="acceuil.php" > <input type="button" name="" value="Acceuil"> </a>

  </body>
</html>
