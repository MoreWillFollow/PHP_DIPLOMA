<?
error_reporting(E_ALL);
include "autoload.php";
include "core.php";

/*echo "<br><pre>";
var_dump($_SESSION);
var_dump($_COOKIE);*/

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
	<title>FAQ</title>
</head>
<body>
<header>
	<h1>FAQ</h1>
</header>

<section class="admin">
    <ul>
        <li><a class="admin_link" href="admin.php" target="_blank">Admin</a></li>
        <li><a class="admin_link" href="exit.php" target="_blank">Выйти</a></li>
    </ul> <!-- cd-faq-categories -->
</section>

<section class="cd-faq">
	<ul class="cd-faq-categories">
<!--		<li><a href="#basics">Basics</a></li>
		<li><a href="#mobile">Mobile</a></li>
		<li><a href="#account">Account</a></li>
		<li><a href="#payments">Payments</a></li>
		<li><a href="#privacy">Privacy</a></li>
		<li><a href="#delivery">Delivery</a></li>
-->

        <?
        $array = categoryArray();
        foreach ($array as $item => $value) {
            echo "<li><a href=\"#".strtolower($value)."\">".$value."</a></li>";
        }
        ?>

	</ul> <!-- cd-faq-categories -->

	<div class="cd-faq-items">

        <?
        $array = answeredQuestionsArray();
/*        echo "<pre>";
        print_r($array);*/
        $header = 0;
        if ($array !== false) {
            foreach ($array as $key=>$question_data){
                if ($header !== $question_data['category_id']) {
                    $header = $question_data['category_id'];
                    $result = findCategoryNameByID($question_data['category_id']);
                }else {
                    $result = NULL;
                }
                ?>

                <ul id="<? echo strtolower($result)?>" class="cd-faq-group">
                    <li class="cd-faq-title"><h2>

                            <?



                            echo $result;


                            ?>



                        </h2>
                    </li>
                    <li>
                        <form action="admin.php" method="post">
                            <label>
                                <button type="submit" name="edit_question" value="<?=$key?>">Редактировать</button>
                            </label>
                        </form>

                        <form action="admin.php" method="post">
                            <label>
                                <button type="submit" name="delete_question" value="<?=$key?>">Удалить</button>
                            </label>
                        </form>
                        <a class="cd-faq-trigger" href="#0"><?=$question_data['question']?></a>

                        <div class="cd-faq-content">
                            <p><?=$question_data['answer']?></p>
                        </div> <!-- cd-faq-content -->
                    </li>

                </ul> <!-- cd-faq-group -->



                <?

            }

        }
        else {
            echo "<h1>Нет отвечанных вопросов.</h1>";
        }
        ?>






















	</div> <!-- cd-faq-items -->
	<a href="#0" class="cd-close-panel">Close</a>
</section> <!-- cd-faq -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery.mobile.custom.min.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
</body>
</html>