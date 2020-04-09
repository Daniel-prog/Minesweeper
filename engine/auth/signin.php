<?php
session_start();
require_once '../connect.php';

$nick = $_POST['nickname'];
$pass = $_POST['pass'];
$sql = "SELECT * FROM `verified_users` WHERE `nickname` = '$nick'";

$error_fields = [];

if ($nick === '' || strlen($nick) > 16) {
    $error_fields[] = 'nickname';
}

if ($pass === '' || strlen($pass) > 16) {
    $error_fields[] = 'pass';
}

if (!empty($error_fields)) {
    $response = [
        'status' => false,
        'type' => 1,
        'message' => 'Проверьте правильность полей!',
        'fields' => $error_fields
    ];

    echo json_encode($response);

    die();
}

$check_user = mysqli_query($connect, $sql);
$user = mysqli_fetch_assoc($check_user);

if (password_verify($pass, $user['password'])) {

    $_SESSION['user'] = [
        'email' => $user['email'],
        'nickname' => $user['nickname']
    ];

    $response = [
        'status' => true
    ];

    echo json_encode($response);

} else {
    $response = [
        'status' => false,
        'message' => 'Неверный логин или пароль!'
    ];
    echo json_encode($response);
}