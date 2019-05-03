<?php
require 'functions.include.php';

session_start();
security();
$db = db_connect();
create_compte();
?>
