<?php
$conn = mysqli_connect("localhost","id16643611_alisher","4q@^RT-_+qY#X*0L","id16643611_zapocetvima");

//$sql = "CREATE DATABASE IF NOT EXISTS zapocetvima";
//if ($conn->query($sql) === FALSE) echo "Error: " . $conn->error;

//mysqli_select_db($conn, "zapocetvima");
$sqlUzivatel = "create table if not exists uzivatel(
             id int not null auto_increment primary key,
             jmeno varchar(255),
             login varchar(255),
             email varchar(255),
             heslo varchar(255));";
mysqli_query($conn, $sqlUzivatel);

$sqlSeznam = "create table if not exists seznam(
             id_seznam int primary key not null auto_increment,
             title varchar(255),
             popis text,
             datum datetime);";
mysqli_query($conn, $sqlSeznam);

$sqlZapis = "create table if not exists zapis(
             id_zapis int not null auto_increment,
             id_uzivatele int references uzivatel(id),
             id_seznam int references seznam(id_seznam),
             primary key (id_zapis,id_uzivatele,id_seznam));";
mysqli_query($conn, $sqlZapis);


if(!$conn){
    die("pdo error: " . mysqli_connect_error());
}

?>