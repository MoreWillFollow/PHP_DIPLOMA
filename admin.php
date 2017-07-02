<?php
error_reporting(E_ALL);
include "core.php";

/*echo "<pre>";
print_r($_POST);*/

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['admin_name'])) {
    $result = assignNewAdmin($_POST['admin_name']);
    if ($result) {
        echo "Админ ".$_POST['admin_name']." назначен администратором.";
    }
    else {
        echo "Пользователь не найден.";
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['change_admin_password']) and !empty($_POST['new_password'])) {
    $result = changeAdminPassword($_POST['change_admin_password'], $_POST['new_password']);
    if ($result) {
        echo "Пароль ".$_POST['change_admin_password']." изменен на: ".$_POST['new_password'].".";
    }
    else {
        echo "Пользователь не найден.";
    }

}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['demote_admin'])) {
    $result = demoteAdmin($_POST['demote_admin']);
    if ($result) {
        echo "Админ ".$_POST['demote_admin']." разжалован.";
    }
    else {
        echo "Пользователь не является админом либо не найден.";
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['delete_admin'])) {
    $result = deleteAdmin($_POST['delete_admin']);
    if ($result) {
        echo "Админ ".$_POST['delete_admin']." удален.";
    }
    else {
        echo "Пользователь не найден.";
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['new_admin_name'])) {
    $result = newNewAdmin($_POST['new_admin_name']);
    $password = randomPassword();
    if ($result) {
        echo "Админ ".$_POST['new_admin_name']." создан. Пароль: ".$password;
    }
    else {
        echo "Пользователь ".$_POST['new_admin_name']." уже существует.";
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['new_category'])) {
    $result = addNewCategory($_POST['new_category']);
    if ($result) {
        echo "Категория ".$_POST['new_category']." создана.";
    }
    else {
        echo "Категория ".$_POST['new_category']." уже существует.";
    }

}


?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
    <link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
    <script src="js/modernizr.js"></script> <!-- Modernizr -->
</head>
<body>
<section class="admin">

    <details>
        <summary>Назначить администратора</summary>
        <form action="admin.php" method="post">
            <label>Имя админа:
                <?
                listNotAdmins('admin_name')
                ?>
            </label>

            <button type="submit">Назначить</button>
        </form>
    </details>

    <details>
        <summary>Сменить пароль администратора</summary>
        <form action="admin.php" method="post">
            <label>Имя админа:
                <?
                listAdmins("change_admin_password")
                ?>
            </label>
            <label>Новый пароль:
            <input type="text" name="new_password" required placeholder="Введите новый пароль">
            </label>

            <button type="submit">Установить пароль</button>
        </form>
    </details>

    <details>
        <summary>Разжаловать администратора</summary>
        <form action="admin.php" method="post">
            <label>Имя админа:
                <?
                listAdmins("demote_admin")
                ?>
            </label>

            <button type="submit">Разжаловать</button>
        </form>
    </details>

    <details>
        <summary>Создать администратора</summary>
        <form action="admin.php" method="post">
            <label>Имя админа:
                <input type="text" name="new_admin_name" placeholder="Введите логин">
            </label>

            <button type="submit">Добавить</button>
        </form>
    </details>

    <details>
        <summary>Удалить администратора</summary>
        <form action="admin.php" method="post">
            <label>Имя админа:
                <?
                listAdmins("delete_admin")
                ?>


            </label>

            <button type="submit">Удалить</button>
        </form>
    </details>

    <details>
        <summary>Добавить новую тему</summary>
        <form action="admin.php" method="post">
            <label>Новая категорию:
                <input type="text" name="new_category" placeholder="Введите новую категорию">
            </label>

            <button type="submit">Добавить</button>
        </form>
    </details>

    <details>
        <summary>Список ответов без вопросов</summary>
        <form action="admin.php" method="post">
            <label>Имя админа:
                <input type="text" name="new_category" placeholder="Введите новую категорию">
            </label>

            <button type="submit">Добавить</button>
        </form>
    </details>

    <details>
        <summary>Список администраторов</summary>
        <ol>
            <?
            listAdminLi();
            ?>
        </ol>
    </details>


</section>
</body>
</html>
