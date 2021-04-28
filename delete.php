<?php
require_once("SelectDB.php");

$selectDB = new SelectDB();
$selectDB ->deleteNote($_POST['id_seznam']);

header('Location: index.php');