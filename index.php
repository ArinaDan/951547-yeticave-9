<?php
require_once 'functions.php';
require_once 'timestamp.php';

$is_auth = rand(0, 1);

$user_name = 'Даниленко Арина'; // укажите здесь ваше имя

$con = mysqli_connect ('localhost', 'root', '', '951547-yeticave-9');
mysqli_set_charset ($con, 'utf8');

$sql_cat = "SELECT `name`, `code` FROM `categories`";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);

$sql_lot = "SELECT `title`, `lot_end`, `price_start`, `price`, `image`, `name` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` GROUP BY `title` ORDER BY `lot_add` DESC";
$result_lot = mysqli_query($con, $sql_lot);
$lots = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);

$page_content = include_template('index.php', [
    'lots' => $lots,
    'categories' => $categories

]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
