<?php

require_once '../connect.php';

$error = '<style>#success { box-shadow: 0 5px 30px 20px rgba(128, 0, 0, 0.5); }</style>';
$success = '<style>#success { box-shadow: 0 5px 30px 20px rgba(0, 128, 0, 0.5); }</style>';

if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];

    if (isset($_GET['email']) && !empty($_GET['email'])) {
        $email = $_GET['email'];

        $query = "SELECT * FROM `users` WHERE `email` = '$email'";
        $query_select_user = mysqli_query($connect, $query);
        $user = mysqli_fetch_assoc($query_select_user);

        $email = $user['email'];
        $nick = $user['nickname'];
        $pass = $user['password'];

        if (mysqli_num_rows($query_select_user) > 0) {
            if ($token == $user['token']) {

                $sql = "INSERT INTO `verified_users` (`id`, `email`, `nickname`, `password`) VALUES (NULL, '$email', '$nick', '$pass')";

                if (mysqli_query($connect, $sql)) {
                    $query_delete = mysqli_query($connect, "DELETE FROM `users` WHERE `email` = '$email'");
                    if (!$query_delete) {
                        $msg = $error . "<strong>Ошибка!</strong> Сбой при удалении данных пользователя из временной таблицы";

                    } else {
                        $msg = $success . '<div>Почта успешно подтверждена!<hr></div> Теперь вы можете войти в свой аккаунт, используя никнейм и пароль.';
                    }
                } else {
                    $msg = $error . 'Ошибка при внесении в базу для подтверждённых пользователей!';
                }

            } else {
                $msg = $error . "<strong>Ошибка!</strong> Неправильный проверочный код.";
            }

        } else {
            $msg = $error . "<strong>Ошибка!</strong> Вы уже зарегистрированы, либо ссылка неверна.";
        }

    } else {
        $msg = $error . "<strong>Ошибка!</strong> Отсутствует адрес электронной почты.";
    }

} else {
    $msg = $error . "<strong>Ошибка!</strong> Отсутствует проверочный код.";
}
