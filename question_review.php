<?php
error_reporting(E_ALL);
include "core.php";

$result = "";
$classResult = "hide";

if (!empty($_POST['sender_name']) and !empty($_POST['sender_mail']) and !empty($_POST['category_id']) and !empty($_POST['question']) and !empty($_POST['edit']) and !empty($_SESSION['question_id'])) {
    $array = questionsArrayByID($_SESSION['question_id']);
    $array = $array[0];


    if (editQuestion($_POST['sender_name'], $_POST['sender_mail'], $_POST['category_id'], $_POST['question'], $array['question_id'])) {

        $result = "Изменения внесены.";
        $classResult = "align-center";
        $classForm = "hide";
    }
    else {
        $result = "Ошибка! Введены не все данные.";
        $classResult = "align-center";
        $classForm = "hide";
    }
}

if (!empty($_SESSION['question_id'])) {

    $array = questionsArrayByID($_SESSION['question_id']);
    $array = $array[0];

    /*    echo "<hr><br>";
        echo "<hr><br>";
        echo "<hr><br>";
        echo $_POST['sender_name'];
        echo "<br>";
        echo $_POST['sender_mail'];
        echo "<br>";
        echo $_POST['category_id'];
        echo "<br>";
        echo $_POST['question'];
        echo "<br>";
        echo $_POST['edit'];
        echo "<br>";
        echo $_SESSION['question_id'];
        echo "<br>";
        echo "<hr><br>";
        echo "<hr><br>";
        echo "<hr><br>";*/
}

/*echo "<pre>";
print_r($_SESSION);*/

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
    <title>Review question</title>
</head>
<body>
<header>
    <h1>Review question</h1>
</header>

<h3 class="<?=$classResult?>"><?=$result?></h3>

<section class="admin">

    <form action="question_review.php" method="post">
        <label>Ваше имя
            <input type="text" name="sender_name" required value="<?=$array['sender_name']?>">
        </label>
        <label>Вашe почту
            <input type="email" name="sender_mail" required value="<?=$array['email']?>">
        </label>

        <label>Категория вопроса:
            <?
            chosenCaregoryList('category_id', $array['category_id']);
            ?>
        </label>
        <br>
        <label for="textarea">Введите ваш вопрос:
        <textarea name="question" rows="10" cols="100%" required><?=$array['question']?></textarea>
        </label>
        <input type="submit" name="edit" value="Изменить">

    </form>


</section>

</body>
</html>