'use strict';

//Убирание красных линий при клике на инпут
$('input').click(function () {
    $('input').removeClass('error');
});

// Авторизация
$('.login-btn').click(function (e) {
    e.preventDefault();
    $(`input`).removeClass('error');

    let login = $('input[name="nickname"]').val(),
        password = $('input[name="pass"]').val();

    $.ajax({
        url: 'engine/auth/signin.php',
        type: 'POST',
        dataType: 'json',
        data: {
            nickname: login,
            pass: password
        },
        success(data) {
            if (data.status) {
                document.location.href = 'index.php';
            } else {
                if (data.type === 1) {
                    data.fields.forEach(function (field) {
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.msg').removeClass('none').text(data.message);
            }
        }
    });
});

//Проверка ника
$('.nick').change(function () {

    let login = $('input[name="nickname"]').val(),
        reg = /^[A-Za-z0-9_-]{4,16}$/;

    if (login === '') { // Если пустой, то убираем див, проверим уже на сервере
        $('.errNick').addClass('none');
    } else { // если не пустой, тогда проверяем на регулярку
        if (!reg.test(login)) {
            $('.errNick').removeClass('none').html('Никнейм должен содержать латинские буквы, 4-16 символов, без разделителей');
        } else { // если проверка на регулярку прошла, проверяем, есть ли такой логин в базе
            $('.errNick').addClass('none');
            $.ajax({
                url: 'engine/reg/checkNick.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    nickname: login,
                },
                success(data) {
                    if (data.status) {
                        $('.errNick').addClass('none');
                    } else {
                        $('.errNick').removeClass('none').html('Пользователь с таким ником уже зарегистрирован!');
                    }
                }
            });
        }
    }
});

// Регистрация
$('.reg-btn').click(function (e) {
    e.preventDefault();

    $(`input`).removeClass('error');

    let email = $('input[name="email"]').val(),
        login = $('input[name="nickname"]').val(),
        password = $('input[name="pass"]').val(),
        password_confirm = $('input[name="pass_confirm"]').val(),
        captcha = $('input[name="norobot"]').val();

    $.ajax({
        url: 'engine/reg/signup.php',
        type: 'POST',
        dataType: 'json',
        data: {
            email: email,
            nickname: login,
            pass: password,
            pass_confirm: password_confirm,
            norobot: captcha
        },
        success(data) {
            if (data.status) {
                document.location.href = 'engine/reg/success.php';
            } else {
                if (data.type === 1) {
                    data.fields.forEach(function (field) {
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.msg').removeClass('none').text(data.message);
            }
        }
    });
    //?r=' + Math.random()
    $('.captchaImg').attr('src', 'engine/captcha.php');
});
