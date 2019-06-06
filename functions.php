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
$categories = [];

$sql = "SELECT * FROM `users`";
$result = mysqli_query($con, $sql);

if ($result !== false) {
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

return $users;
}

/**
* Выбирает все лоты
* @param string $ con Осуществляет соединение с базой данных
* @return array
*/
function get_all_lots($con) {
$lots = [];

$sql = "SELECT `lots`.*, MAX(price) as `price`,  `name` as `category_name` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` GROUP BY `title` ORDER BY `lot_add` DESC";
$result = mysqli_query($con, $sql);

if ($result !== false) {
$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);	
}

return $lots;
}

/**
* Выполныет сложение 2 параметров лота
* @param array $ lot Массив с данными лота
* @return array
*/
function get_min_bid($lot) {
return intval($lot['price'] ?: $lot['price_start']) + intval($lot['bid_step']);
}