<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

$categories = get_all_categories($con);
$errors = [];

$page_content = include_template('error.php', [
    'errors' => $errors,
    'categories' => $categories
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Ошибка',
    'user_name' => $_SESSION['user']['name']
]);

print($layout_content);