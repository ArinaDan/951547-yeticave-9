<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

$is_auth = rand(0, 1);

$user_name = 'Даниленко Арина'; // укажите здесь ваше имя



$page_content = include_template('index.php', [
    'lots' => $lots,
    'categories' => $categories,
    'con' => $con,
    'lots' => $lots
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная',
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'con' => $con
]);

print($layout_content);
