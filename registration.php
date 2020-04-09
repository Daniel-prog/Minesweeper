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
    <span class="regauthTitle">Регистрация</span>
    <label>Email</label>
    <input type="email" placeholder="Ваш Email" name="email" maxlength="129">
    <label>Никнейм</label>
    <input type="text" placeholder="Ваш никнейм" name="nickname" class="nick" maxlength="16" autocomplete="off">
    <div class="errNick none"></div>
    <label>Пароль</label>
    <input type="password" placeholder="Пароль (минимум 6 символов)" name="pass" maxlength="16">
    <label>Повтор пароля</label>
    <input type="password" name="pass_confirm" placeholder="Повторите пароль" maxlength="16">

    <label>Введите число с картинки:</label>
    <input type="text" name="norobot" maxlength="4" autocomplete="off">
    <img src="engine/captcha.php" class="captchaImg">

    <button class="reg-btn">Зарегистрироваться</button>
    <p>
        У вас уже есть аккаунт? <a href="auth.php">Авторизируйтесь</a>
    </p>
    <p class="msg none"></p>
</form>

</body>
<script src="assets/js/jquery-3.4.1.min.js"></script>
<script src="assets/js/validation.js"></script>
</html>