<?php
require_once 'helpers.php';

/**
* Выполняет округление и форматирование числа. Итог - целое число с делением на разряды
* @param int $ price Число для форматирования
* @return string
*/
function price_format ($price) {
    $price = ceil ($price);
    $price = number_format($price, 0, '', ' ');
    $result = $price . ' ₽';

    return $result;    
}

/**
* Преобразует html-символы в безопасный unicode
* @param string $ text Текст для форматирования
* @return string
*/
function esc($str) {
	$text = htmlspecialchars($str);

	return $text;
}

/**
* Выбирает все категории
* @param string $ con Осуществляет соединение с базой данных
* @return array
*/
function get_all_categories($con) {
$categories = [];

$sql = "SELECT * FROM `categories`";
$result = mysqli_query($con, $sql);

if ($result !== false) {
	$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

return $categories;
}

/**
* Выбирает всю информацию по юзеру
* @param string $ con Осуществляет соединение с базой данных
* @return array
*/
function get_all_users($con) {
$users = [];

$sql = "SELECT * FROM `users`";
$result = mysqli_query($con, $sql);

if ($result !== false) {
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

return $users;
}

/**
* Выбирает все ставки лота
* @param string $ con Осуществляет соединение с базой данных
* @param string $ lot_id Идентификатор лота, для которого отбираются ставки. Получаем из $_GET
* @return array
*/
function get_all_lot_bids($con, $lot_id) {
$lot_bids = [];

$sql = "SELECT `bids`.*, `name` FROM `bids` LEFT JOIN `users` ON `user` = `user_id`  WHERE `lot` = {$lot_id} ORDER BY `bid_add` DESC";
$result = mysqli_query($con, $sql);

if ($result !== false) {
	$lot_bids = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

return $lot_bids;
}


/**
* Выбирает все лоты
* @param string $ con Осуществляет соединение с базой данных
* @return array
*/
function get_all_lots($con) {
$lots = [];

$sql = "SELECT COUNT(*) as `cnt`, `lots`.*, MAX(price) as `price`,  `name` as `category_name` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` WHERE `lot_end` > NOW() GROUP BY `title` ORDER BY `lot_add` DESC";
$result = mysqli_query($con, $sql);

if ($result !== false) {
$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);	
}

return $lots;
}

/**
* Выбирает все лоты одной категории
* @param string $ con Осуществляет соединение с базой данных
* @param string $ category_name Код категории, для которого отбираются ставки
* @return array
*/
function get_one_category_lots($con, $category_code) {
$cat_lots = [];

$sql = "SELECT `lots`.*, MAX(price) as `price`, `name`, `code` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` WHERE `code` = '{$category_code}' GROUP BY `title` ORDER BY `lot_add` DESC";
$result = mysqli_query($con, $sql);

if ($result !== false) {
$cat_lots = mysqli_fetch_all($result, MYSQLI_ASSOC);	
}

return $cat_lots;
}

/**
* Выбирает все лоты по поиску
* @param string $ con Осуществляет соединение с базой данных
* @param string $ search поисковый запрос
* @return array
*/
function get_search_lots($con, $search) {
$search_lots = [];

$sql = "SELECT `lots`.*, MAX(price) as `price`, `name`, `code` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` WHERE MATCH(`title`, `description`) AGAINST('{$search}') GROUP BY `title` ORDER BY `lot_add` DESC";
$result = mysqli_query($con, $sql);

if ($result !== false) {
$search_lots = mysqli_fetch_all($result, MYSQLI_ASSOC);    
}

return $search_lots;
}

function get_one_user_bids($con, $user_id) {
$user_bids = [];
$sql = "SELECT `bid_id`, `bid_add`, `lots`.*, `price`, `user` AS `user_id`, `categories`.`name`, `contacts`, `winner_id` FROM `bids` LEFT JOIN `lots` ON `lot` = `lot_id` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `users` ON `user` = `user_id` WHERE `user` = {$user_id} ORDER BY `bid_add` DESC";
$result = mysqli_query($con, $sql);

if ($result !== false) {
$user_bids = mysqli_fetch_all($result, MYSQLI_ASSOC);    
}

return $user_bids;
}

/**
* Выполняет сложение 2 параметров лота
* @param array $ lot Массив с данными лота
* @return array
*/
function get_min_bid($lot) {
return intval($lot['price'] ?: $lot['price_start']) + intval($lot['bid_step']);
}

/**
* Вычисляет время, прошедшее с момента создания ставки
* @param array $ bid Массив с данными ставки
* @return string
*/
function get_bid_expire($bid) {
$add = strtotime($bid['bid_add']);

$diff = time() - $add;
    
$hours = floor($diff / 3600);
$minutes = floor($diff % 3600 / 60);

if ($hours >= 1 && $hours < 24) {
    return $hours . ' ' . get_noun_plural_form ($hours, 'час назад', 'часа назад','часов назад');
}
if ($hours < 1) {
    return $minutes . ' ' . get_noun_plural_form ($minutes, 'минуту назад', 'минуты назад', 'минут назад');
}
return date('d.m.y в H:i', $add);
}