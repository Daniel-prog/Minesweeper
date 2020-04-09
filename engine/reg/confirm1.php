<?php
session_start();
require_once '../connect.php';

$email = $_SESSION['email'];
$username = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `nickname` FROM `users` WHERE `email` = '$email'"));
$username = $username['nickname'];
unset($_SESSION['email']);

$token = md5($email . time());
$query = "UPDATE `users` SET `token`='$token', `date_of_registration`=NOW() WHERE `email`='$email'";

$query_unverified = mysqli_query($connect, $query);

if (!$query_unverified) {
    $div_msg = 'Не удалось произвести запись в базу данных!';

} else {
    $subject = "Подтверждение почты на сайте " . $_SERVER['HTTP_HOST'];

    //Устанавливаем кодировку заголовка письма и кодируем его
    $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

    $message = 'Здравствуйте! <br/> <br/> Сегодня ' . date("d.m.Y", time()) . ', неким пользователем была произведена регистрация на сайте <a href="' . $address_site . '">' . $_SERVER['HTTP_HOST'] . '</a> используя Ваш email. Если это были Вы, то, пожалуйста, подтвердите адрес вашей электронной почты, перейдя по этой ссылке: <a href="' . $address_site . 'engine/reg/end-reg.php?token=' . $token . '&email=' . $email . '">' . $address_site . 'end-reg/' . $token . '</a> <br/> <br/> В противном случае, если это были не Вы, то, просто игнорируйте это письмо. <br/> <br/> <strong>Внимание!</strong> Ссылка действительна 24 часа. После чего Ваш аккаунт будет удален из базы.';
    $headers = "FROM: $email_admin\r\nReply-to: $email_admin\r\nContent-type: text/html; charset=utf-8\r\n";
    if (mail($email, $subject, $message, $headers)) {
        $div_msg = "<div>Последний шаг<hr></div>Здравствуйте, $username!<br><br>Добро пожаловать на наш сайт! Для окончания регистрации перейдите по ссылке в письме, отправленном на вашу почту $email.";

    } else {
        $div_msg = "<p class='mesage_error' >Ошибка при отправлении письма с сылкой подтверждения, на почту " . $email . " </p>";
    }
}

