<?php

require 'functions.include.php';
session_start();
security();
change_data();
$dataAccount = getAccountDetails($_POST['idCompte']);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Acceuil</title>
  </head>
  <body>
    <form class="form_1" method="POST" action="">
      <div>
      <input type="hidden" name="idCompte" value="<?= $_POST['idCompte']; ?>"/>
      <label for="nom_compte">Nouveau nom de Compte</label>
      <input type="text" name="nom_compte" value="<?= $dataAccount['nom_compte']; ?>"  maxlength="15">
      </div>
      <div>
        <p>Sélectionner le nouveau type de compte : </p>
          <input type="radio" name="type_compte" value="courant" <?= $dataAccount['type_compte'] == "courant" ? 'checked' : '' ?>>
          <label for="type_compte">Compte courant</label><br>
          <input type="radio" name="type_compte" value="epargne" <?= $dataAccount['type_compte'] == "epargne" ? 'checked' : '' ?>>
          <label for="type_compte">Epargne </label><br>
          <input type="radio" name="type_compte" value="joint" <?= $dataAccount['type_compte'] == "joint" ? 'checked' : '' ?>>
          <label for="type_compte">Compte joint</label><br><br>
      </div>

      <label for="nom_compte">Nouveau montant montant du compte</label>
      <input type="number" name="amount" value="<?= $dataAccount['provision']; ?>" max="99999999" step="0.01" required>

      <select name="devise_compte">
          <option value="eur" <?= $dataAccount['devise'] == "eur" ? 'selected' : '' ?>>EUR</option>
          <option value="usd" <?= $dataAccount['devise'] == "usd" ? 'selected' : '' ?>>USD</option>
      </select>

      <br><br>

      <input type="submit" name="updateAccount" value="Submit">
    </form>


    <a href="acceuil.php"> <input type="button" name="" value="Acceuil"> </a>

  </body>
</html>
