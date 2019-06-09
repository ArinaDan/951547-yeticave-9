<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

$categories = get_all_categories($con);

$cur_page = $_GET['page'] ?? 1;
$page_items = 2;
$offset = ($cur_page - 1) * $page_items;
    
$result = mysqli_query($con, "SELECT COUNT(*) as `cnt` FROM `lots` WHERE `lot_end` > NOW()");
$lots_count = mysqli_fetch_assoc($result)['cnt'];
$pages_count = ceil($lots_count / $page_items);

$pages = range(1, $pages_count);

$sql = "SELECT `lots`.*, MAX(price) as `price`,  `name` as `category_name` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` WHERE `lot_end` > NOW() GROUP BY `title` ORDER BY `lot_add` DESC LIMIT {$page_items} OFFSET {$offset}";

$lots = mysqli_query($con, $sql);

$sql_win = "SELECT *, MAX(`bid_id`) AS `bid_win` FROM `lots` INNER JOIN `bids` ON `lot_id` = `lot` WHERE `winner_id` IS NULL AND `lot_end` < NOW() GROUP BY `lot_id`";
$res = mysqli_query($con, $sql_win);
$res_win = mysqli_fetch_all($res, MYSQLI_ASSOC);
   
foreach ($res_win as $winner) {
   $sql_win1 = "SELECT `users`.* FROM `bids` left JOIN `users` ON `user` = `user_id` WHERE `bid_id` = {$winner['bid_win']}";
   $res1 = mysqli_query($con, $sql_win1);
   $res_win1 = mysqli_fetch_assoc($res1);

   $winner_id = $res_win1['user_id'];
   $lot_id = $winner['lot_id'];

   $sql = "UPDATE `lots` SET `winner_id` = {$winner_id} WHERE `lot_id` = {$lot_id}";
   $res = mysqli_query($con, $sql);
}


$page_content = include_template('index.php', [
    'lots' => $lots,
    'categories' => $categories,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page

]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная',
    'user_name' => $_SESSION['user']['name']
]);

print($layout_content);