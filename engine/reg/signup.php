<?php
session_start();
require_once '../connect.php';

$email = $_POST['email'];
$nick = $_POST['nickname'];
$pass = $_POST['pass'];
$confirmPass = $_POST['pass_confirm'];
$error_fields = [];
$reg = '/^[A-Za-z0-9_-]{4,16}$/';
$regPass = '/^[A-Za-z0-9_-]{6,16}$/';

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 129) {
    $error_fields[] = 'email';
}

if ($nick === '' || !preg_match($reg, $nick) || strlen($nick) > 16) {
    $error_fields[] = 'nickname';
}

if ($pass === '' || strlen($pass) > 16 || !preg_match($regPass, $pass)) {
    $error_fields[] = 'pass';
}

if ($confirmPass === '' || strlen($confirmPass) > 16) {
    $error_fields[] = 'pass_confirm';
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

$check_email = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email'");
if (mysqli_num_rows($check_email) > 0) {
    $response = [
        'status' => false,
        'type' => 1,
        'message' => 'Такой email уже зарегистрирован!',
        'fields' => ['email']
    ];
    echo json_encode($response);

    die();
}

$check_email = mysqli_query($connect, "SELECT * FROM `verified_users` WHERE `email` = '$email'");
if (mysqli_num_rows($check_email) > 0) {
    $response = [
        'status' => false,
        'type' => 1,
        'message' => 'Такой email уже зарегистрирован!',
        'fields' => ['email']
    ];
    echo json_encode($response);

    die();
}

$check_login = mysqli_query($connect, "SELECT * FROM `users` WHERE `nickname` = '$nick'");
if (mysqli_num_rows($check_login) > 0) {
    $response = [
        'status' => false,
        'type' => 1,
        'message' => 'Пользователь с таким ником уже существует!',
        'fields' => ['nickname']
    ];
    echo json_encode($response);

    die();
}

$check_login = mysqli_query($connect, "SELECT * FROM `verified_users` WHERE `nickname` = '$nick'");
if (mysqli_num_rows($check_login) > 0) {
    $response = [
        'status' => false,
        'type' => 1,
        'message' => 'Пользователь с таким ником уже существует!',
        'fields' => ['nickname']
    ];
    echo json_encode($response);

    die();
}

if (md5($_POST['norobot']) !== $_SESSION['randomnr2']) {
    $response = [
        'status' => false,
        'type' => 2,
        'message' => "Неправильный номер с картинки!",
    ];
    echo json_encode($response);

    die();
}

if ($pass === $confirmPass) {

    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO `users` (`id`, `email`, `nickname`, `password`) VALUES (NULL, '$email', '$nick', '$pass')";
    $a = mysqli_query($connect, $sql);
    if ($a) {
        $response = [
            'status' => true
        ];
        $_SESSION['email'] = $email;
        echo json_encode($response);

    } else {
        $response = [
            'status' => false,
            'message' => 'Не удалось выполнить запрос к БД!'
        ];
        echo json_encode($response);
    }
} else {
    $response = [
        'status' => false,
        'message' => 'Пароли не совпадают!'
    ];
    echo json_encode($response);
}
