<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

$is_auth = rand(0, 1);

$user_name = 'Даниленко Арина'; // укажите здесь ваше имя



if (isset($_GET['id'])) {
        $url = $_GET['id'];

$sql_lot = "SELECT `title`, `lot_end`, `price_start`, `description`, `image`, MAX(price) as `price`,  `name` as `category_name`, `bid_step`, `lot_id` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` WHERE `lot_id` = '$url' GROUP BY `title` ORDER BY `lot_add` DESC";
$result_lot = mysqli_query($con, $sql_lot);
$lots = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);

    }



$page_content = include_template('lot.php', [
    'lots' => $lots,
    'categories' => $categories,
    'con' => $con
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Лот',
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'con' => $con
]);

print($layout_content);