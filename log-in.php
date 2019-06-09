<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

$categories = get_all_categories($con);
$users = get_all_users($con);
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST;
    //проверка обязательных полей
    $required = ['e-mail', 'password'];
    foreach ($required as $fieldname) {
        if (!isset($user[$fieldname]) || empty(trim($user[$fieldname]))) {
    		$errors[$fieldname] = 'Заполните поле';
    	}
    	if (empty($errors['e-mail']) && !filter_var($user['e-mail'], FILTER_VALIDATE_EMAIL)) {
        $errors['e-mail'] = 'Введите корректный e-mail';
        }
    }

    $mail = mysqli_real_escape_string($con, $user['e-mail']);
    $sql = "SELECT * FROM `users` WHERE `e-mail` = '$mail'";
    $res = mysqli_query($con, $sql);
    $cur_user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!count($errors) and $cur_user) {
		if (password_verify($user['password'], $cur_user['password'])) {
			$_SESSION['user'] = $cur_user;
			header("Location: index.php");
		} else {
			$errors['password'] = 'Неверный пароль';}
	}
	else {
		$errors['e-mail'] = 'Пользователь не найден';
	} 
}

$page_content = include_template('log-in.php', [
    'users' => $users,
    'errors' => $errors,
    'categories' => $categories
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Вход'
]);

print($layout_content);