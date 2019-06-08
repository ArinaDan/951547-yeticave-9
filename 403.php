<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';


$categories = get_all_categories($con);
http_response_code(403);

$page_content = include_template('403.php', [
    'categories' => $categories
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Доступ запрещен'
]);

print($layout_content);