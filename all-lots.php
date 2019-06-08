<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

$categories = get_all_categories($con);
$lots = get_all_lots($con);
$category_name = $_GET['name'];
$cat_lots = get_one_category_lots($con, $category_name);

if (empty($cat_lots)) {

header('Location: error.php');

}

$page_content = include_template('all-lots.php', [
    'lots' => $lots,
    'cat_lots' => $cat_lots,
    'categories' => $categories,
    'category_name' => $category_name

]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $cat_lots[0]['name'],
    'user_name' => $_SESSION['user']['name']
]);

print($layout_content);