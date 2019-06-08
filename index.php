<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

$lots = get_all_lots($con);
$categories = get_all_categories($con);
   
   $sql_win = "SELECT *, MAX(`bid_id`) AS `bid_win`, MAX(`price`) as `new_price` FROM `lots` LEFT JOIN `bids` ON `lot_id` = `lot` WHERE `winner_id` IS NULL AND `lot_end` < NOW() GROUP BY `lot_id`";
   $res_w = mysqli_query($con, $sql_win);
   $res_win = mysqli_fetch_all($res_w, MYSQLI_ASSOC);

foreach ($res_win as $gg) {
$bid_id = $gg['bid_id'];

   $sql_win1 = "SELECT * FROM `bids` left JOIN `users` ON `user` = `user_id` WHERE `bid_id` = $bid_id";
   $res_w1 = mysqli_query($con, $sql_win1);
   $res_win1 = mysqli_fetch_all($res_w1, MYSQLI_ASSOC);

  $winner_id = $res_win1['user'];
  $lot_id = $res_win1['lot'];

  $sql = "UPDATE `lots` SET `winner_id` = {$winner_id} WHERE `lot_id` = {$lot_id}";
  $res = mysqli_query($con, $sql);

}

var_dump($res);

$page_content = include_template('index.php', [
    'lots' => $lots,
    'categories' => $categories,
    'sql_win' => $sql_win,
'res_win' => $res_win,
'res_w' => $res_w

]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная',
    'user_name' => $_SESSION['user']['name']
]);

print($layout_content);
