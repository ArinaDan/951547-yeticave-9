<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

$categories = get_all_categories($con);
$category_code = mysqli_real_escape_string($con, $_GET['code']);

$name = mysqli_query($con, "SELECT `name` FROM `categories` WHERE `code` = '{$category_code}'");
$category_name = mysqli_fetch_assoc($name)['name'];

if (empty($category_name)) { 
	header('Location: error.php');
}

    $cur_page = $_GET['page'] ?? 1;
    $page_items = 2;
    $offset = ($cur_page - 1) * $page_items;
    
    $result = mysqli_query($con, "SELECT COUNT(*) as `cnt` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` WHERE `lot_end` > NOW() AND `code` = '{$category_code}'");
    $lots_count = mysqli_fetch_assoc($result)['cnt'];
    $pages_count = ceil($lots_count / $page_items);

    $pages = range(1, $pages_count);

$sql = "SELECT `lots`.*, `name`, `code` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` WHERE `code` = '{$category_code}' ORDER BY `lot_add` DESC LIMIT {$page_items} OFFSET {$offset}";
$cat_lots = mysqli_query($con, $sql);


$page_content = include_template('all-lots.php', [
    'lots' => $lots,
    'cat_lots' => $cat_lots,
    'categories' => $categories,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page,
    'category_code' => $category_code,
    'category_name' => $category_name

]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => '',
    'user_name' => $_SESSION['user']['name']
]);

print($layout_content);