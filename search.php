<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

$categories = get_all_categories($con);

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $search = trim($_GET['search'] ?? '');

    $cur_page = $_GET['page'] ?? 1;
    $page_items = 2;
    $offset = ($cur_page - 1) * $page_items;
    //заэкранировать серч
    if ($search) {
    $search = mysqli_real_escape_string($con, $search);
    $result = mysqli_query($con, "SELECT COUNT(*) as `cnt` FROM `lots` WHERE `lot_end` > NOW() AND MATCH(`title`, `description`) AGAINST('{$search}')");
    $lots_count = mysqli_fetch_assoc($result)['cnt'];
    $pages_count = ceil($lots_count / $page_items);
    $pages = range(1, $pages_count);


        $sql = "SELECT `lots`.*, MAX(price) as `price`, `name`, `code` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` WHERE NOW() < `lot_end` AND MATCH(`title`, `description`) AGAINST(?) GROUP BY `title` ORDER BY `lot_add` DESC LIMIT {$page_items} OFFSET {$offset}";

        $stmt = db_get_prepare_stmt($con, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);

        $search_lots = mysqli_fetch_all($results, MYSQLI_ASSOC);
    } else {header('Location: error.php');}
}


$page_content = include_template('search.php', [
    'lots' => $lots,
    'categories' => $categories,
    'search_lots' => $search_lots,
    'search' => $search,
                    'pages' => $pages,
            'pages_count' => $pages_count,
            'cur_page' => $cur_page

]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Lot',
    'user_name' => $_SESSION['user']['name']
]);

print($layout_content);