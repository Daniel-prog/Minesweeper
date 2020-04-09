<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Сапёр онлайн</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../assets/css/regauth.css">
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Righteous&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="header1">
        <img src="assets/img/mineH.png" alt="Мина" width="50" height="50">
        <a class="name" href="index.php">Minesweeper Classic</a>
        <img src="assets/img/mineH.png" alt="Мина" width="50" height="50">
    </div>
</header>

<form>
    <a href="index.php" class="home" title="На главную">◄</a>
    <span class="regauthTitle">Авторизация</span>
    <label>Никнейм</label>
    <input type="text" name="nickname" placeholder="Введите никнейм, указанный при регистрации">
    <label>Пароль</label>
    <input type="password" name="pass" placeholder="Введите свой пароль">
    <button type="submit" class="login-btn">Войти</button>
    <p>
        У вас ещё нет аккаунта? <a href="registration.php">Зарегестрируйтесь!</a>
    </p>
    <p class="msg none"></p>
</form>

</body>
<script src="assets/js/jquery-3.4.1.min.js"></script>
<script src="assets/js/validation.js"></script>
</html>
