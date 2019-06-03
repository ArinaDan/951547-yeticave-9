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

$sql = "SELECT `name`, `code` FROM `categories`";
$result = mysqli_query($con, $sql);

if ($result !== false) {
	$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

return $categories;
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

/**
* Добавляет класс если поле не заполнено
* @param string $field Данные из массива POST
* @return string
*/
function add_form_status_class(string $field) : string
{
    $y = empty($field);

    return $y = TRUE ? 'form__item--invalid' : '';
}

function add_new_lot($con) {
  $title = $_POST['title'];
  $category = $_POST['category'];
  $description = $_POST['description'];
  $image = $_POST['image'];
  $price_start = $_POST['price_start'];
  $bid_step = $_POST['bid_step'];
  $lot_end = $_POST['lot_end'];

  $sql = "INSERT INTO users (`title`, `description`, `image`, `price_start`, `bid_step`, `lot_end`) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $sql_add = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($sql_add, 'si', $title, $category, $description, $image, $price_start, $bid_step, $lot_end);
  mysqli_stms_execute($sql_add);
}

