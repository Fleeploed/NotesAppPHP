<?php
require "DataBase.php";
$db = new DataBase();
echo $db->deleteNote($_POST['id_seznam']);