<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

if (!isset($_GET['id'])) {

header('Location: error.php');

}

$lot_id = (int) /*преобразование к числу*/ $_GET['id'];

$sql_lot = "SELECT `lots`.*, MAX(price) as `price`,  `name` as `category_name` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` WHERE `lot_id` = {$lot_id} GROUP BY `lot_id` ORDER BY `lot_add` DESC";
$result_lot = mysqli_query($con, $sql_lot);
$lot = mysqli_fetch_assoc($result_lot);

if (empty($lot)) {

header('Location: error.php');

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
    'user_name' => $_SESSION['user']['name']
]);

print($layout_content);