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
$sql_lot = "SELECT `title`, `lot_end`, `price_start`, `description`, `image`, MAX(price) as `price`,  `name` as `category_name`, `bid_step`, `lot_id` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` GROUP BY `title` ORDER BY `lot_add` DESC";
$result_lot = mysqli_query($con, $sql_lot);
$lots = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);

return $lots;
}

function new_price($con) {
$sql_lot = "SELECT `title`, `lot_end`, `price_start`, `description`, `image`, MAX(price) as `price`,  `name` as `category_name`, `bid_step` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot`  GROUP BY `title`";
$result_lot = mysqli_query($con, $sql_lot);
$lots = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);

$p = $lots['price_start'];
$b = $lots['bid_step'];
$pp = $lots['price'];


	if ($pp === NULL) {
		$new_price = $p + $b;
	}
	else {
		$new_price = $pp + $b;
	}

	return $new_price;
}