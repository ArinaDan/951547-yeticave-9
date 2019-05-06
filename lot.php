<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

$is_auth = rand(0, 1);

$user_name = 'Даниленко Арина'; // укажите здесь ваше имя



if (!isset($_GET['id'])) {

header('Location: 404.php');

}

$lot_id = (int) /*преобразование к числу*/ $_GET['id'];

$sql_lot = "SELECT `title`, `lot_end`, `price_start`, `description`, `image`, MAX(price) as `price`,  `name` as `category_name`, `bid_step`, `lot_id` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` WHERE `lot_id` = {$lot_id} GROUP BY `lot_id` ORDER BY `lot_add` DESC";
$result_lot = mysqli_query($con, $sql_lot);
$lot = mysqli_fetch_assoc($result_lot);

if (empty($lot)) {

header('Location: 404.php');

}

$categories = get_all_categories($con);

$page_content = include_template('lot.php', [
    'lot' => $lot,
    'categories' => $categories
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Лот',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);