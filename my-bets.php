<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

    if (!isset($_SESSION['user']['name'])) {
        header('Location: 403.php');
    }
$user_id = $_SESSION['user']['user_id'];
$categories = get_all_categories($con);
$lots = get_all_lots($con);
$lot_bids = get_all_lot_bids($con, $lot_id);
$user_bids = get_one_user_bids($con, $user_id);


$page_content = include_template('my-bets.php', [
    'lot' => $lot,
    'lots' => $lots,
    'user_id' => $user_id,
    'categories' => $categories,
    'lot_bids' => $lot_bids,
    'lot_bid' => $lot_bid,
    'user_bids' => $user_bids
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $lots[$lot_id]['title'],
    'user_name' => $_SESSION['user']['name']
]);

print($layout_content);