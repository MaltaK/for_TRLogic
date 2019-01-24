<?php

header("Content-Type: text/html; charset=UTF-8");

$db_host= 'localhost';
$db_user= 'u0522692_default';
$db_pass= 'JGyA7zW!';
$db_database= 'u0522692_default';

$link = new mysqli($db_host, $db_user, $db_pass, $db_database);
if($link->connect_errno) die("Нет соеднинения с БД");
$link->query("SET NAMES utf8");
$link->set_charset("utf8");

?>