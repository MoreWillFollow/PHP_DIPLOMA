<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.06.17
 * Time: 2:17
 */

error_reporting(E_ALL);
echo "<pre>";

/* CONNECTION AND SQL REQUESTS */
function connect() {
    $pdo = new PDO("mysql:host=localhost; dbname=clvrdgtl_php_dip", "clvrdgtl_php_dip", "netology2017", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    return $pdo;
}

$password = "admin";

$user = "Ешкин Кошкин Кот";
$email = "sobaka@mail.ru";
$category = 3;
$question = "Как быть если вопрсо не загружается?";
function askQuestion($user, $email, $category, $question) {
    $pdo = connect();
    $sql = $pdo->prepare('INSERT INTO questions (sender_name, email, category_id, question) VALUES (:sender_name, :email, :category, :question)');
    $sql->bindParam(':sender_name', $user, PDO::PARAM_STR);
    $sql->bindParam(':email', $email, PDO::PARAM_STR);
    $sql->bindParam(':category', $category, PDO::PARAM_STR);
    $sql->bindParam(':question', $question, PDO::PARAM_STR);

    $sql->execute();
    return true;
}



if (askQuestion($user, $email, $category, $question)) {

    echo "Ваш вопрос отправлен. Ждите ответа.";
}
else {
    echo "Ошибка! Введены не все данные.";
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
<!--<section class="admin">
    <details>
        <summary>Добавить администратора</summary>
        <form action="test.php" method="post">
            <label>Имя админа:
                <input type="text" name="new_admin" placeholder="Введите логин">
            </label>

            <button type="submit">Назначить</button>
        </form>
    </details>
</section>-->
</body>
</html>
