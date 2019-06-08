<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

$categories = get_all_categories($con);

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $search = trim($_GET['search']);
}

    if ($search) {

        $sql = "SELECT `lots`.*, MAX(price) as `price`, `name`, `code` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` WHERE NOW() < `lot_end` AND MATCH(`title`, `description`) AGAINST(?) GROUP BY `title` ORDER BY `lot_add` DESC";

        $stmt = db_get_prepare_stmt($con, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $search_lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } 

$page_content = include_template('search.php', [
    'lot' => $lot,
    'lots' => $lots,
    'categories' => $categories,
    'search_lots' => $search_lots,
    'search_lot' => $search_lot,
    'search' => $search

]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Lot',
    'search_lots' => $search_lots,
    'user_name' => $_SESSION['user']['name']
]);

print($layout_content);