<?php
require_once 'connect.php';
session_start();

$nickname = $_SESSION['user']['nickname'];

$query = "SELECT `records` FROM `verified_users` WHERE `nickname` = '$nickname'";
$json_records = mysqli_query($connect, $query);

$json_records = mysqli_fetch_assoc($json_records);

if ($json_records['records'] !== NULL) {
    echo $json_records['records'];
}