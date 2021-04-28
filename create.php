<?php
require_once("SelectDB.php");
$selectDB = new SelectDB();


if ($_POST['id_seznam'])
    $selectDB->updateNote($_POST['id_seznam'], $_POST);
else
    $selectDB->addNote($_POST);
header('Location: index.php');