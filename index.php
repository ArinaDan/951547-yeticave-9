<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

$lots = get_all_lots($con);
$categories = get_all_categories($con);

$page_content = include_template('index.php', [
    'lots' => $lots,
    'categories' => $categories
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная',
    'user_name' => $_SESSION['user']['name']
]);

print($layout_content);
