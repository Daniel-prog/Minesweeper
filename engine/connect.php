<?php

$connect = mysqli_connect('localhost', 'f0425542_minesweeper', '663001dan', 'f0425542_minesweeper');

if (!$connect) {
    die('Ошибка подключения к базе данных!');
}

$query_delete_users = mysqli_query($connect, "DELETE FROM `users` WHERE `date_of_registration` < ( NOW() - INTERVAL 1 DAY )");

if (!$query_delete_users) {
    die("<p><strong>Ошибка!</strong> Сбой при удалении просроченного аккаунта.</p>");
}

$address_site = "http://f0425542.xsph.ru/";

$email_admin = "admin@minesweeper.me";