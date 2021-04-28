<?php
require "DataBase.php";
$db = new DataBase();
echo $db->updateNote($_POST['id_seznam'], $_POST['title'], $_POST['popis']);
