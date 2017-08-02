<?php

require_once 'functions.php';
$cookie_expire = time() + 900; //30 минут на сохранение авторизации по умолчанию, больше при галке запомнить 
$error_msg = '';

$user = new user();

if (empty($_COOKIE['blc'])) {

    static $login_attempts = 0;
} else {

    $login_attempts = $_COOKIE['blc'];
}


if (isset($_COOKIE['passkey']) && isset($_COOKIE['login'])) {


    if ($user->is_auth($_COOKIE['login'], $_COOKIE['passkey'])) {


        if (isset($_COOKIE['name'])) {

            echo 'Здравствуйте ' . $_COOKIE['name'];
            echo '<br>';
        }

        echo '<a href="logout.php">Выйти</a>';

        die;
    }
}


if (isset($_POST['submit'])) {




    if ($user->exist($_POST['login']) && !empty($_POST['password'])) {
        //echo 'Такой пользователь существует<br>'; 
        if (isset($_POST['remember'])) {
            $cookie_expire = time() + 10800;
        }

        if ($user->start_auth($_POST['login'], $_POST['password'], $cookie_expire)) {

            //echo 'Успешная авторизация';
            header('location: list.php');
            // redirect to list.php
        } else {

            $error_msg = 'Неверный логин или пароль';
            setcookie('blc', ++$login_attempts, time() + 160);

            include'templates/login.php';
        }
    } else if (!empty($_POST['login']) && !$user->exist($_POST['login']) && (empty($_POST['password']))) {

        echo 'Здравствуй гость ' . $_POST['login'];
        setcookie('guest_name', $_POST['login']);
        header('location: list.php');
    } else {

        $error_msg = 'Ошибка авторизации';
        setcookie('blc', ++$login_attempts, time() + 160);
        include'templates/login.php';
    }

    //var_dump($_POST);
    die;
}

include'templates/login.php';
?>