<?php

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['psw'];
$passwordRepeat = $_POST['psw-repeat'];

$errors = [];

if (empty($name)) {
    $errors['name'] = "Имя не может быть пустым!";
} elseif (strlen($name) < 2) {
    $errors['name'] = "Имя должно быть больше 2 символов!";
}

if (empty($email)) {
    $errors['email'] = "Поле Email не может быть пустым!";
} elseif (strlen($email) < 2) {
    $errors['email'] = "Email должен быть больше 2 символов!";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Некорректный Email';
}
print_r($password);
if (empty($password)) {
    $errors['password'] = "Поле пароль не может быть пустым!";
} elseif (strlen($password) < 5) {
    $errors['password'] = "Пароль должен быть больше 5 символов!";
}
if ($password !== $passwordRepeat) {
    $errors['passwordRepeat'] = "Пароли не совпадают!";
}



if (empty($errors)) {
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=dbname", "dbuser", "dbpwd");

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);


    $stat = $pdo -> prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stat->execute([':name' => $name, ':email' => $email, ':password' => $passwordHash]);



    $stat = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stat->execute(['email' => $email]);
    $count = $stat->fetchColumn();
    if ($count > 0) {
        $errors['email'] = "Email уже существует";
    }


}

print_r($errors);
require_once './get_registration.php';
