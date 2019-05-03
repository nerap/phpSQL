<?php
require 'functions.include.php';

session_start();

security();


if(isset($_POST['delete'])){
  sup_Operation($_POST['deleting']);
}

$dataAccount = getAccountData();
$dataOperation = getDataCategory($dataAccount);



 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
      <form class="form_1" method="POST" action="operation_edit.php">
         <label>Choisir opération</label>
         <select name="id_Operation">
           <?php
             foreach ($dataOperation as $value) {
                foreach ($value as $compte) {
                  echo "<option value=".$compte['id'].">". $compte['nom_operation'] .$compte['montant_operation'] . "</option>";
              }
             }
           ?>
         </select>
         <br>
         <input type="submit" name="operation_choisir_submit" value="Submit">
      </form>
    <form class="form_1" method="POST" action="">
      <select name="deleting">
        <?php
          foreach ($dataOperation as $value) {
             foreach ($value as $compte) {
               echo "<option value=".$compte['id'].">". $compte['nom_operation'] .$compte['montant_operation'] . "</option>";
           }
          }
        ?>
      </select>
      <br>
      <input type="submit" name="delete" value="Delete">
    </form>
   </body>
 </html>
