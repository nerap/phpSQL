<?php
require 'functions.include.php';

session_start();

security();


operation_edit();

$dataAccount = getAccountData();
$dataCategory = getCategorydetails();


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
         <input type="text" name="operationName"><br>
         <label for="operationAmount">Montant opération</label>
         <input type="number" name="operationAmount" set="0.01" max="99999999"><br>
         <label for="idCompte">Choisir compte</label>
         <select name="idCompte">
           <?php
             foreach ($dataAccount as $compte) {
               echo '<option value="'.$compte['id'].'">' . $compte['nom_compte'] . '(' . $compte['provision'] . ')</option>';
             }
           ?>
         </select>

         <br>
          <label for="idOperation">Choisir Categorie</label>

         <select name="idOperation">
           <?php
             foreach ($dataCategory as $compte) {
               echo '<option value="' . $compte['id'] . '">' . $compte['nom_categorie'] . '(' . $compte['type'] . ')</option>';
             }
           ?>
         </select>
         <br>
         <input type="submit" name="operation_submit" value="Submit">
      </form>
   </body>
 </html>
