<?php

require_once '../connect.php';

$nick = $_POST['nickname'];

$check_login = mysqli_query($connect, "SELECT * FROM `users` WHERE `nickname` = '$nick'");
if (mysqli_num_rows($check_login) > 0) {
    $response = [
        'status' => false,
        'type' => 1,
        'message' => 'Пользователь с таким ником уже существует!',
        'fields' => ['nickname']
    ];
    echo json_encode($response);

} else {
    $response = [
        'status' => true,
    ];
    echo json_encode($response);
}
