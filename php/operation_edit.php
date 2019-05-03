<?php
require 'functions.include.php';

session_start();

security();

operation_edit();


if (isset($_POST['operation_choisir_submit']))
  $dataOperationDetails = getdataOperationDetails($_POST['id_Operation']);
var_dump($dataOperationDetails);

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
      <form class="form_1" method="POST" action="">
         <label for="operationName">Nom de l'opération</label>
         <input type="text" name="operationName" value="<?= $dataOperationDetails[4]; ?>"><br>
         <label for="operationAmount">Montant opération</label>
         <input type="number" name="operationAmount" set="0.01" max="99999999" value=".<?= $dataOperationDetails['montant_operation'];  ?>."><br>
         <label for="idCompte">Choisir compte</label>
         <select name="idCompte">
           <?php
             foreach ($dataAccount as $compte) {
               echo '<option value="' . $compte['id'] . '">' . $compte['nom_compte'] . '(' . $compte['provision'] . ')</option>';
             }
           ?>
         </select>

         <br>
          <label for="idOperation">choisir operation</label>

         <select name="idOperation">
           <?php
             foreach ($dataCategory as $compte) {
               echo '<option value="' . $compte['id'] . '">' . $compte['nom_categorie'] . '(' . $compte['type'] . ')</option>';
             }
           ?>
         </select>
         <br>
         <input type="submit" name="operation_edit" value="Submit">
      </form>
        <a href="acceuil.php" > <input type="button" name="" value="Acceuil"> </a>
   </body>
 </html>
