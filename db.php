<?php

$con = mysqli_connect ('localhost', 'root', '', '951547-yeticave-9');

if ($con == false) {
	exit ("Ошибка" . mysqli_connect_error($con));
} 

mysqli_set_charset ($con, 'utf8');

function cat($con) {
$sql_cat = "SELECT `name`, `code` FROM `categories`";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);

return $categories;
}

function lots($con) {
$sql_lot = "SELECT `title`, `lot_end`, `price_start`, `image`, MAX(price) as `price`,  `name` as `category_name` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` GROUP BY `title` ORDER BY `lot_add` DESC";
$result_lot = mysqli_query($con, $sql_lot);
$lots = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);

return $lots;
}