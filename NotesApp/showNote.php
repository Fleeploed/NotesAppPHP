<?php
require "DataBase.php";
$db = new DataBase();
echo $db->showNote($_POST['id_user']);