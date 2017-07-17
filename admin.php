<?php
error_reporting(E_ALL);
include "core.php";

/*echo "<pre>";
print_r($_POST);*/

if (isMethodPost()) {
    if (!empty($_POST['publish_question'])) {
        publishQuestion($_POST['publish_question']);
    }

    if (!empty($_POST['publish_question'])) {
        publishQuestion($_POST['publish_question']);
    }

    if (!empty($_POST['category_delete'])) {
        deleteQuestionsInCategory($_POST['category_delete']);
        deleteCategory($_POST['category_delete']);

    }

    if (!empty($_POST['delete_question'])) {
        deleteQuestionByID($_POST['delete_question']);
        echo "Вопрос с ID = ".$_POST['delete_question']." удален.";
    }

    if (!empty($_POST['edit_question'])) {
        $_SESSION['question_id'] = $_POST['edit_question'];
        redirectPageTo('question_review');

    }

    if (!empty($_POST['admin_name'])) {
        $result = assignNewAdmin($_POST['admin_name']);
        if ($result) {
            echo "Админ ".$_POST['admin_name']." назначен администратором.";
        }
        else {
            echo "Пользователь не найден.";
        }

    }

    if (!empty($_POST['change_admin_password']) and !empty($_POST['new_password'])) {
        $result = changeAdminPassword($_POST['change_admin_password'], $_POST['new_password']);
        if ($result) {
            echo "Пароль ".$_POST['change_admin_password']." изменен на: ".$_POST['new_password'].".";
        }
        else {
            echo "Пользователь не найден.";
        }

    }


    if (!empty($_POST['demote_admin'])) {
        $result = demoteAdmin($_POST['demote_admin']);
        if ($result) {
            echo "Админ ".$_POST['demote_admin']." разжалован.";
        }
        else {
            echo "Пользователь не является админом либо не найден.";
        }

    }

    if (!empty($_POST['delete_admin'])) {
        $result = deleteAdmin($_POST['delete_admin']);
        if ($result) {
            echo "Админ ".$_POST['delete_admin']." удален.";
        }
        else {
            echo "Пользователь не найден.";
        }

    }

    if (!empty($_POST['new_admin_name'])) {
        $result = newNewAdmin($_POST['new_admin_name']);
        $password = randomPassword();
        if ($result) {
            echo "Админ ".$_POST['new_admin_name']." создан. Пароль: ".$password;
        }
        else {
            echo "Пользователь ".$_POST['new_admin_name']." уже существует.";
        }

    }

    if (!empty($_POST['new_category'])) {
        $result = addNewCategory($_POST['new_category']);
        if ($result) {
            echo "Категория ".$_POST['new_category']." создана.";
        }
        else {
            echo "Категория ".$_POST['new_category']." уже существует.";
        }

    }
}


?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin page</title>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
    <link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
    <script src="js/modernizr.js"></script> <!-- Modernizr -->
</head>
<body>
<section class="admin">
    <p>Администраторы</p>
    <hr>

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
        <summary>Список администраторов</summary>
        <ol>
            <?
            listAdminLi();
            ?>
        </ol>
    </details>
    <br><br><br>

    <p>Работа с темами</p>
    <hr>


    <details>
        <summary>Удалить тему со всеми вопросами</summary>
        <form action="admin.php" method="post">
            <label>Удаляемая категория:
                <?
                listCategory("category_delete")
                ?>
            </label>

            <button type="submit">Удалить категорию и все вопросы в ней</button>
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
    <details open>
        <summary>Список тем и статистика</summary>
        <table>
            <tr>
                <th>Тема</th>
                <th>Всего вопросов</th>
                <th>Опубликовано</th>
                <th>Без ответов</th>
            </tr>


            <?
            $array = themeStats();
            foreach ($array as $key => $value) {
                echo "<tr>";
                echo "<td>".$value['category']."</td>";
                echo "<td>".$value['count']."</td>";
                echo "<td>".$value['published']."</td>";
                echo "<td>".$value['no_answer']."</td>";
                echo "</tr>";
            }
            ?>

        </table>
    </details>

    <br><br><br>

    <p>Работа с вопросами и ответами</p>
    <hr>


    <details open>
        <summary>Список вопросов без ответов</summary>

        <table>
            <tr>
                <th>ID вопроса</th>
                <th>Имя отправителья</th>
                <th>E-mail отправителья</th>
                <th>Категория вопроса</th>
                <th>Вопрос</th>
                <th>Ответ</th>
                <th>Опубликован</th>
                <th>Действия</th>
            </tr>
            <?
            $array = unansweredQuestionsArray();

            if (!empty($array)) {
                foreach ($array as $key=>$value) {
                    echo "<tr>";
                    echo "<td>".$value['question_id']."</td>";
                    echo "<td>".$value['sender_name']."</td>";
                    echo "<td>".$value['email']."</td>";
                    echo "<td>".findCategoryNameByID($value['category_id'])."</td>";
                    echo "<td>".$value['question']."</td>";
                    echo "<td>".$value['answer']."</td>";
                    echo "<td>".publishedOrNot($value['publish'])."</td>";
                    echo "<td>";
                    ?>

                    <form action="admin.php" method="post">
                        <label>
                            <button type="submit" name="edit_question" value="<?=$value['question_id']?>">Редактировать</button>
                        </label>
                    </form>

                    <form action="admin.php" method="post">
                        <label>
                            <button type="submit" name="delete_question" value="<?=$value['question_id']?>">Удалить</button>
                        </label>
                    </form>

                    <?
                    echo "</td>";
                    echo "<tr>";


                }
            }
            else {
                echo "<br>Все вопросы отвечены или их нет<br><br><br>";
            }


            ?>


        </table>

    </details>
<br>
    <details open>
        <summary>Список всех вопросов и статусы</summary>

        <table>
            <tr>
                <th>ID вопроса</th>
                <th>Имя отправителья</th>
                <th>E-mail отправителья</th>
                <th>Категория вопроса</th>
                <th>Вопрос</th>
                <th>Ответ</th>
                <th>Опубликован</th>
                <th>Дата добавления</th>
                <th>Действия</th>
            </tr>
            <?
            $array = allQuestionsArray();
            if (!empty($array)) {
                foreach ($array as $key=>$value) {
                    echo "<tr>";
                    echo "<td>".$value['question_id']."</td>";
                    echo "<td>".$value['sender_name']."</td>";
                    echo "<td>".$value['email']."</td>";
                    echo "<td>".findCategoryNameByID($value['category_id'])."</td>";
                    echo "<td>".$value['question']."</td>";
                    echo "<td>".$value['answer']."</td>";
                    echo "<td>".publishedOrNot($value['publish'])."</td>";
                    echo "<td>".$value['date_added']."</td>";
                    echo "<td>";
                    ?>

                    <form action="admin.php" method="post">
                        <label>
                            <button type="submit" name="edit_question" value="<?=$value['question_id']?>">Редактировать</button>
                        </label>
                    </form>

                    <form action="admin.php" method="post">
                        <label>
                            <button type="submit" name="delete_question" value="<?=$value['question_id']?>">Удалить</button>
                        </label>
                    </form>

                    <form action="admin.php" method="post">
                        <label>
                            <button type="submit" name="publish_question" value="<?=$value['question_id']?>">Опубликовать</button>
                        </label>
                    </form>

                    <?
                    echo "</td>";
                    echo "<tr>";


                }
            }
            else {
                echo "<br>Вопросов нет<br><br><br>";

            }
            ?>


        </table>

    </details>







</section>
</body>
</html>
