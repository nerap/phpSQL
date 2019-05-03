<?php
require "functions.include.php";
session_start();
$_SESSION['logged'] = false;
$db = db_connect();
//unset($_SESSION);
//session_destroy();
if (isset($_POST['delete_account'])){
  delete_user();
  header('Location: index.php');
}
log_user();
log_create_user();

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <form action="" method="post">
      <label for="login">Login</label>
      <input type="text" name="login" autocomplete="new-password"/>
      <label for="password">Password</label>
      <input type="password" name="password" />

      <input type="submit" name="submitlogin" value="Enter">
    </form>

    <form action="" method="post">
      <label for="login">Choose Login</label>
      <input type="text" name="loginCreate" />
      <label for="password">Choose Password</label>
      <input type="password" name="mdpCreate" />

      <input type="submit" name="submitAccount" value="Enter">
    </form>
    <Copyright (c) 2018 Copyright Holder All Rights Reserved.>
  </body>
</html>
