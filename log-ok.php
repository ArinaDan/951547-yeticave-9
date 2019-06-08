<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';


$categories = get_all_categories($con);


$page_content = include_template('log-ok.php', [
    'categories' => $categories
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Регистрация завершена'
]);

print($layout_content);