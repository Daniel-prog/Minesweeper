<?php require_once 'activation.php'; ?>

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
        <img src="../../assets/img/mineH.png" alt="Мина" width="50" height="50">
        <a class="name" href="../../index.php">Minesweeper Classic</a>
        <img src="../../assets/img/mineH.png" alt="Мина" width="50" height="50">
    </div>
</header>

<div id="success">
    <?= $msg ?>
    <a href="../../index.php" class="homeBtn">На главную</a>
</div>

</body>
</html>
