<?php
require "DataBase.php";
$db = new DataBase();
echo $db->saveNote($_POST['id_user'],$_POST['title'], $_POST['popis']);
