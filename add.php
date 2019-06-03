<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

$is_auth = rand(0, 1);

$user_name = 'Даниленко Арина'; // укажите здесь ваше имя

$lots = get_all_lots($con);
$categories = get_all_categories($con);

$page_content = include_template('add-lot.php', [
    'lots' => $lots,
    'lot' => $lot,
    'categories' => $categories
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Добавить лот',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);


print($layout_content);