<?php


function db_connect(){
  try {
    $host = "localhost";
    $db_name = "php";
    $user = "root";
    $password = "root";

    $db = new PDO("mysql:host=$host;dbname=$db_name",$user,$password);
    return $db;
  } catch (Exception $e) {
    die("Erreur : ".$e->getMessage());
  }
}

function security(){
  $db = db_connect();
  if(!isset($_SESSION['id'])){
    header('Location: index.php');
  }
}

function getDateOperation($id){
  $db = db_connect();

  $req = $db->prepare("SELECT * FROM Categorie WHERE Categorie.id_compte = :id ORDER BY DESC Categorie.date_operation ");
  $req->execute(array(
    ':id' => $id
  ));
  return $req->fetchAll();
}

function getAccountData() {
  $db = db_connect();

  $req  = $db->prepare("SELECT C.nom_compte, C.id, C.provision FROM Compte as C WHERE id_utilisateur = :id");
  $req->execute(array(
    ':id'  => $_SESSION['id']
  ));

  return $req->fetchAll();
}




function getDataOperationById($id){
  $db = db_connect();

  $req = $db->prepare("SELECT * FROM Operations WHERE Operations.id_compte = :id_cat");
  $req->execute(array(
    ':id_cat' => $id
  ));
  return $req->fetchAll();
}



function getDataCategory($dataAcc){
  $tab = array();
  foreach($dataAcc AS $value){
    array_push($tab, getDataOperationById($value['id']));
  }
  return $tab;
}

function getCategorydetails(){
  $db = db_connect();

  $req = $db->prepare("SELECT * FROM Categorie");

  return $req-> execute();
}

function getdataOperationDetails($id){
  $db = db_connect();

  $req = $db->prepare("SELECT * FROM Operations WHERE :id = Operations.id");
  $data = $req->execute(array(
    ':id' => $id
  ));

  return $req->fetchAll();
}

function sup_Operation($id_op){
  $db = db_connect();
  $req = $db->prepare("DELETE FROM Operations
                        WHERE :id = Operations.id ");
  $req->execute(array(
    ':id' => $id_op
  ));
}

function operation_edit(){
  if(isset($_POST['operation_edit'])) {
    try {
      if ($_POST['idCompte'] != null && $_POST['idOperation'] != null && $_POST['operationName'] != null && $_POST['operationAmount'] != null) {
        $db = db_connect();
        $req = $db->prepare("INSERT INTO Operations (id_compte, id_categorie, nom_operation, montant_operation)
        VALUES (:id_acc, :id_cate, :name,:amount)");
        $req->execute(array(
          ':id_acc' => (int)$_POST['idCompte'],
          ':id_cate' => (int)$_POST['idOperation'],
          ':name' => $_POST['operationName'],
          ':amount' => (float)$_POST['operationAmount']
        ));
        header('Location: acceuil.php');
      }
      else {
      throw new Exception("erreur");
      }
    }
    catch (Exception $e){
      echo '<script>alert("' . $e->getMessage() . '")</script>';
    }
  }
}

function getAccountDetails($idAcount){
    $db = db_connect();

    $req  = $db->prepare("SELECT C.* FROM Compte as C WHERE id_utilisateur = :id AND C.id = :idAccount");
    $req->execute(array(
      ':id'  => $_SESSION['id'],
      ':idAccount' => $idAcount
    ));

    return $req->fetch();
}



function change_data(){

  if (isset($_POST['updateAccount'])){
    try {
      if (($_POST['nom_compte'] != null && strlen($_POST['nom_compte']) < 15)
       && in_array($_POST['type_compte'], array("courant", "joint", "epargne"))
       && $_POST['amount'] != null && strlen($_POST['nom_compte']) <= 11
       && in_array($_POST['devise_compte'], array("eur", "usd"))) {
         $db = db_connect();
        $req = $db->prepare("UPDATE Compte
        SET nom_compte = :nom, type_compte = :type, provision = :provision, devise = :devise
        WHERE id_utilisateur = :id");
        $req->execute(array(
          ':id'  => $_SESSION['id'],
          ':nom' => $_POST['nom_compte'],
          ':type' => $_POST['type_compte'],
          ':provision'  => $_POST['amount'],
          ':devise' => $_POST['devise_compte']
      ));
    }
    else {
      throw new Exception("Input error");
    }
    }catch(Exception $e){
      echo '<script>alert("' . $e->getMessage() . '")</script>';
    }
  }
}

function delete_user(){
  $db = db_connect();
  $req = $db->prepare(" DELETE FROM Utilisateur
                        WHERE :id = Utilisateur.id ");
  $req->execute(array(
    ':id' =>  $_SESSION['id']));
}

function create_compte(){
  $db = db_connect();
  if(isset($_POST['send']))
  {
      try {
        if (($_POST['nom_compte'] != null && strlen($_POST['nom_compte']) < 15)
         && in_array($_POST['type_compte'], array("courant", "joint", "epargne"))
         && $_POST['amount'] != null && strlen($_POST['nom_compte']) <= 11
         && in_array($_POST['devise_compte'], array("eur", "usd"))) {
          $req = $db->prepare("SELECT COUNT(id) AS patate FROM Compte WHERE id_utilisateur = :id");
          $req->execute(array(':id' => $_SESSION['id']));
          $data = $req->fetch();
          if ($data['patate']  > 10)
              echo "Arret de spam";
          else
          {
              $req = $db->prepare(" INSERT INTO Compte (id_utilisateur, nom_compte, type_compte, provision, devise)
                                    VALUES (:id, :nom_compte, :type_compte, :provision, :devise)");
              $req->execute(array(
                ':id'           => $_SESSION['id'],
                ':nom_compte'   => $_POST['nom_compte'],
                ':type_compte'  => $_POST['type_compte'],
                ':provision'    => $_POST['amount'],
                ':devise'       => $_POST['devise_compte']

              ));
          }
          header('Location: acceuil.php');
        }
        else {
          throw new Exception("Input error");
        }
      }
      catch(Exception $e){
        echo '<script>alert("' . $e->getMessage() . '")</script>';
      }
  }
}

function log_user(){
  $db = db_connect();
  if(isset($_POST['submitlogin']) && $_SESSION['logged'] == false){
    try {
      if ($_POST['login']  != null){
        $req = $db->prepare("SELECT id FROM Utilisateur WHERE email_utilisateur = :email AND mot_de_passe = :mdp");
        $req->execute(array(':email' => $_POST['login'], ':mdp' => $_POST['password']));
        $data = $req->fetch();
        if ($req->rowCount() != 0){
          $_SESSION['logged'] = true;
          $_SESSION['id'] = $data['id'];
          header('Location: acceuil.php');
        }
        else
          throw new Exception("Mauvais id");
      }
      else
        throw new Exception("Error Processing Request");
    }
    catch(Exception $e){
      echo '<script>alert("' . $e->getMessage() . '")</script>';
    }
  }




}

function log_create_user(){
  $db = db_connect();
  if (isset($_POST['submitAccount']) && $_SESSION['logged'] == false){
    try {
      if ($_POST['loginCreate'] != null && strlen($_POST['loginCreate']) < 10) {
        if ($_POST['mdpCreate'] != null && strlen($_POST['mdpCreate']) < 10) {
          $_req = $db->prepare(" INSERT INTO Utilisateur (email_utilisateur, mot_de_passe)
                                VALUES (:email, :mdp)");
          $_req->execute(array(
            ':email' => $_POST['loginCreate'],
            ':mdp' => $_POST['mdpCreate']
          ));
          $_req = $db->prepare("SELECT U.id FROM Utilisateur AS U WHERE U.email_utilisateur = :email");
          $_req->execute(array(
            ':email' => $_POST['loginCreate']
          ));
          $data = $_req->fetch();
          $_SESSION['logged'] = true;
          $_SESSION['id'] = $data['id'];
          header('Location: acceuil.php');
        }
        else {
          throw new Exception("No input mdp create");
        }
      }
      else {
        throw new Exception(  "No input login create");
      }
    }
    catch (Exception $e){
      echo '<script>alert("' . $e->getMessage() . '")</script>';
    }
  }
}
