<?php

include "oop/class/mdPassword.php";

/* CONNECTION AND SQL REQUESTS */
function connect() {
$pdo = new PDO("mysql:host=localhost; dbname=clvrdgtl_php_dip", "clvrdgtl_php_dip", "netology2017", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
return $pdo;
}

/* METHOD CHEKERS*/

function isMethodPost () {
    if (    $_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    else {
        return false;
    }
}


/* USER authentication */
function userLogin ($login, $pass) {
    $pdo = connect();
    $pass = makeHash($pass);
    $sql = $pdo->prepare("SELECT * FROM users WHERE login = :login");
    $sql->bindParam(':login', $login, PDO::PARAM_STR);
    $sql->execute();
    $sql = $sql->fetchAll();
    $result = $sql;
    if (!empty($sql) and isset($sql)) {
        foreach ($sql as $row) {
            if ($row["login"] == $login and $row["pass"] == $pass) {
                $result = true;
            }
            else {
                $result = false;
            }
        }
    }
    else {
        $result = false;
    }
    return $result;

}


/* USER authorization */

function checkUserStatus ($login, $pass) {
    $pdo = connect();

    $sql = $pdo->prepare("SELECT * FROM users WHERE login = :login");
    $sql->bindParam(':login', $login, PDO::PARAM_STR);
    $sql->execute();
    $sql = $sql->fetchAll();
    if (!empty($sql) and isset($sql)) {
        foreach ($sql as $row) {
            if ($row["admin"] == 1) {
                $result = 1;
            }
            elseif ($row["admin"] != 1) {
                $result = 0;
            }
        }
    }
    else {
        $result = "Ошибка!";
    }
    return $result;

}

/* Checking Logined or not */
function ifLogined () {
    if (empty($_SESSION['login'])) {
        header('Location: index.php');
    }
    return (!empty($_SESSION['login']));
}


/* ADMIN LIST in OPTION */

function listAdmins ($action_name) {
    $pdo = connect();
    $sql = $pdo->prepare("SELECT * FROM users WHERE admin = 1");
    $sql->execute();
    $sql = $sql->fetchAll();
    echo "<select name=\"".$action_name."\">";
    foreach ($sql as $row) {
        echo "<option value=\"".$row["login"]."\">".$row["login"]."</option>";

    }
    echo "</select>";
}

/* NOT ADMIN LIST in OPTION */

function listNotAdmins ($action_name) {
    $pdo = connect();
    $sql = $pdo->prepare("SELECT * FROM users WHERE admin = 0");
    $sql->execute();
    $sql = $sql->fetchAll();
    echo "<select name=\"".$action_name."\">";
    foreach ($sql as $row) {
        echo "<option value=\"".$row["login"]."\">".$row["login"]."</option>";

    }
    echo "</select>";
}

function listAdminLi () {
    $pdo = connect();
    $sql = $pdo->prepare("SELECT * FROM users WHERE admin = 1");
    $sql->execute();
    $sql = $sql->fetchAll();
    foreach ($sql as $row) {
        echo "<li>";
        echo $row['login'];
        echo "</li>";
    }
}

/* ASSIGN ADMIN*/

function assignNewAdmin($admin_name) {
    $pdo = connect();

    $select = $pdo->prepare("SELECT * FROM users WHERE login = :admin_name");
    $select->bindParam(':admin_name', $admin_name, PDO::PARAM_STR);
    $select->execute();
    $select=$select->fetchAll();
    if (empty($select)) {
        return false;
    }
    $sql = $pdo->prepare("UPDATE users SET admin = 1 WHERE login = :admin_name");
    $sql->bindParam(':admin_name', $admin_name, PDO::PARAM_STR);
    $sql->execute();
    return true;
}

/* CREATE NEW ADMIN */


function newNewAdmin($new_admin_name) {

    $pdo = connect();
    $select = $pdo->prepare("SELECT * FROM users WHERE login = :new_admin_name");
    $select->bindParam(':new_admin_name', $new_admin_name, PDO::PARAM_STR);
    $select->execute();
    $select=$select->fetchAll();
    if (!empty($select)) {
        return false;
    }

    $password = makeHash(randomPassword());
    $sql = $pdo->prepare("INSERT INTO users (login, admin, pass) VALUES (:login, 1, :password)");
    $sql->bindParam(':login', $new_admin_name, PDO::PARAM_STR);
    $sql->bindParam(':password', $password, PDO::PARAM_STR);
    $sql->execute();
    return $password;
}

/* DEMOTE ADMINISTRATOR */

function demoteAdmin($demote_admin) {
    $pdo = connect();

    $select = $pdo->prepare("SELECT * FROM users WHERE login = :demote_admin AND admin = 1");
    $select->bindParam(':demote_admin', $demote_admin, PDO::PARAM_STR);
    $select->execute();
    $select=$select->fetchAll();
    if (empty($select)) {
        return false;
    }
    $sql = $pdo->prepare("UPDATE users SET admin = 0 WHERE login = :demote_admin");
    $sql->bindParam(':demote_admin', $demote_admin, PDO::PARAM_STR);
    $sql->execute();
    return true;
}


/* DELETE ADMINISTRATOR */

function deleteAdmin($delete_admin_name) {
    $pdo = connect();
    $sql = $pdo->prepare("DELETE FROM users WHERE login = :login");
    $sql->bindParam(':login', $delete_admin_name, PDO::PARAM_STR);
    $sql->execute();
    return true;
}



/* HASH PASSWORD */

function makeHash($password) {
    $salt = '6464321564dsa654f651asdf2165345531#@$%$^ %  %# % #$]\'\]q]\az.xc,mfsd==/9874-+-+45486$*&&#55HQ7$5$7QW';
    $password = md5($password.$salt);
    return $password;
}

/* CHANGE ADMIN PASSWORD */

function changeAdminPassword ($admin_name, $password) {
    $password = makeHash($password);
    $pdo = connect();
    $sql = $pdo->prepare('UPDATE users SET pass = :password WHERE login = :login');
    $sql->bindParam(':login', $admin_name, PDO::PARAM_STR);
    $sql->bindParam(':password', $password, PDO::PARAM_STR);
    $sql->execute();
    return true;
}

/* RANDOM PASSWORD GENERATOR */
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}



/* ASK QUESTION*/

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



/* LIST CATEGORY */


function listCategory ($action_name) {
    $pdo = connect();
    $sql = $pdo->prepare("SELECT * FROM category");
    $sql->execute();
    $sql = $sql->fetchAll();
    echo "<select name=\"".$action_name."\">";
    foreach ($sql as $row) {
        echo "<option value=\"".$row["category_id"]."\">".$row["category"]."</option>";

    }
    echo "</select>";
}





