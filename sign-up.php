<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

$user_id = 1;

$categories = get_all_categories($con);
$users = get_all_users($con);
$errors = [];
$user = [];


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST;
    //проверка обязательных полей
    $required = ['e-mail', 'password', 'name', 'contacts'];
    foreach ($required as $fieldname) {
        if (!isset($user[$fieldname]) || empty(trim($user[$fieldname]))) {
    		$errors[$fieldname] = 'Заполните поле';
    	}
    } 
     // правильность заполнения 
    if (empty($errors['e-mail']) && !filter_var($user['e-mail'], FILTER_VALIDATE_EMAIL)) {
        $errors['e-mail'] = 'Введите корректный e-mail';
    }
    
    $mail = mysqli_real_escape_string($con, $user['e-mail']);
    $sql = "SELECT `e-mail` FROM `users` WHERE `e-mail` = '$mail'";
    $res = mysqli_query($con, $sql);

    if (mysqli_num_rows($res) > 0) {
        $errors['e-mail'] = 'Такой e-mail уже существует';
    }

    if (empty($errors['name']) && is_numeric($user['name'])) {
        $errors['name'] = 'Введите свое имя';
    }

    if (empty($errors)) {	
        $password = password_hash($user['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` (`e-mail`, `password`, `name`, `contacts`) VALUES (?, ?, ?, ?)";
        $sql_add = db_get_prepare_stmt($con, $sql, [$user['e-mail'], $password, $user['name'], $user['contacts']]);
        $res = mysqli_stmt_execute($sql_add);
        header("Location: add.php");
    }

    //else {$content = include_template('error.php', ['error' => mysqli_error($link)]);}**/
} 

$page_content = include_template('sign-up.php', [
    'users' => $users,
    'user' => $user,
    'errors' => $errors,
    'categories' => $categories
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Регистрация нового пользователя'
]);

print($layout_content);