<?php

$errors = [];

#session_start();
#$_SESSION['userId'];


if (isset($_POST['username'])) {
    $username = $_POST['username'];
} else {
    $errors['username'] = "Username is required";
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
} else {
    $errors['password'] = "Password is required";
}

$pdo = new PDO("pgsql:host=db; port=5432; dbname=dbname", "dbuser", "dbpwd");
$stat = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stat->execute(['email' => $username]);
$result = $stat->fetch();

if (!empty($result)) {
    if (isset($result['password'])) {
        $passwordHash = $result['password'];
    } else {
        die('Error.');
    }

    #проверка пароля
    if (password_verify($password, $passwordHash)) {

        session_start();
        $_SESSION['userId'] = $result['id'];
        #setcookie('userId', $result['id']);
    } else {
        $errors['username'] = "Wrong password or username";
    }
} else {
    $errors['username'] = "Wrong password or username";
}
