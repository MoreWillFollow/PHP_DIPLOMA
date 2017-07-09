
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

<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.06.17
 * Time: 2:17
 */

error_reporting(E_ALL);
echo "<pre>";

function countQuestionByTheme ($category_id) {
    $pdo = connect();
    $sql = $pdo -> prepare('SELECT COUNT(question_id)
FROM questions;');
    $sql = $sql->execute();

    return $sql;
    

}



/*
function countQuestionByTheme ($category_id) {
    $pdo = connect();
    $sql = $pdo -> prepare('SELECT COUNT (question_id) FROM questions WHERE category_id = :category_id');
    $sql -> bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $sql = $sql->execute();

    return $sql;


}*/

var_dump(countQuestionByTheme(2));



















/* CONNECTION AND SQL REQUESTS */
function connect() {
    $pdo = new PDO("mysql:host=localhost; dbname=clvrdgtl_php_dip", "clvrdgtl_php_dip", "netology2017", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    return $pdo;
}

?>
