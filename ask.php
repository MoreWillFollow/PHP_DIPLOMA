<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.06.17
 * Time: 17:03
 */
include "core.php";
$classResult = "hide";


if (isMethodPost()) {
    if (!empty($_POST['sender_name']) and !empty($_POST['sender_mail']) and !empty($_POST['category_id']) and !empty($_POST['question_text']) and !empty($_POST['ask'])) {

        if (askQuestion($_POST['sender_name'],$_POST['sender_mail'], $_POST['category_id'], $_POST['question_text'])) {

            $result = "Ваш вопрос отправлен. Ждите ответа.";
            $classResult = "align-center";
            $classForm = "hide";
        }
        else {
            $result = "Ошибка! Введены не все данные.";
            $classResult = "align-center";
            $classForm = "hide";
        }
    }


}

?>


<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
    <link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
    <script src="js/modernizr.js"></script> <!-- Modernizr -->
    <title>ASK</title>
</head>
<body>
<header>
    <h1>ASK QUESTION</h1>
</header>

<section class="admin">

    <form action="ask.php" method="post" class="<?=$classForm?>">
        <label>Ваше имя
            <input type="text" name="sender_name" required placeholder="Введите ваше имя">
        </label>
        <label>Вашe почту
            <input type="email" name="sender_mail" required placeholder="Введите ваш почтовый адрес">
        </label>

        <label>Категория вопроса:
            <?
            listCategory('category_id');
            ?>
        </label>
        <br>
        <label for="textarea">Введите ваш вопрос: </label>
        <textarea name="question_text" rows="10" cols="100%" required placeholder="Введите текст, чтобы задать вопрос."></textarea>
        <input type="submit" name="ask" value="Спросить">

    </form>

    <h3 class="<?=$classResult?>"><?=$result?></h3>
</section>

</body>
</html>
