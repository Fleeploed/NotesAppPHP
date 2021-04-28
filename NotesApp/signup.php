<?php
require "DataBase.php";
$db = new DataBase();
echo $db->signUp($_POST['jmeno'], $_POST['login'], $_POST['email'], $_POST['heslo']);
?>