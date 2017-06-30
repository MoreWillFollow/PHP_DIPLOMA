<?php

error_reporting(E_ALL);
session_start();
include "functions.php";
if (isMethodPost()) {


    $login = $_POST['login'];
    $pass = $_POST['password'];

    if (userLogin($login, $pass)) {
        setcookie('user', "", time() + 3600);
        $_SESSION['admin'] = checkUserStatus($login, $pass);
        $_SESSION['login'] = $login;
        unset($_SESSION['password']);
    /*    var_dump($_SESSION);*/
    /*    echo "<pre><hr>";*/
        header('Location: index.php');
    /*    var_dump($_SESSION);*/
}
else {
        echo "Не верный пароль или логин. Попробуйте еще раз.<br>";
}
}

?>

<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<form action="login.php" method="post">
    <label for="login">Логин:
        <input type="text" name="login" placeholder="Введите логин">
    </label>

    <label for="password">Пароль:
        <input type="password" name="password" placeholder="Введите ваш пароль">
    </label>

    <button type="submit">Войти</button>

</form>
</body>

</html>
