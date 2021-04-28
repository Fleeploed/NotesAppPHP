<?php
require "DataBase.php";
$db = new DataBase();
echo $db->signIn($_POST['login'], $_POST['heslo']);
