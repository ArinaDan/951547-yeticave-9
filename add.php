<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

$is_auth = rand(0, 1);

$user_name = 'Даниленко Арина'; // укажите здесь ваше имя
$user_id = 1;

$lots = get_all_lots($con);
$categories = get_all_categories($con);
$errors = [];
$lot = [];


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lot = $_POST;
    //проверка обязательных полей
    $required = ['title', 'category', 'description', 'price_start', 'bid_step', 'lot_end'];
    foreach ($required as $fieldname) {
        if (!isset($lot[$fieldname]) || empty(trim($lot[$fieldname]))) {
    		$errors[$fieldname] = 'Заполните поле';
    	}
    } 
    if (empty($_FILES['image']) || empty($_FILES['image']['tmp_name'])) {
    	$errors['image'] = 'Загрузите фото';
    }
    // правильность заполнения
    if (empty($errors['price_start']) && (!is_numeric($lot['price_start']) || intval($lot['price_start']) <= 0)) {
        $errors['price_start'] = 'Введите число больше 0';
    }
    if (empty($errors['bid_step']) && (!is_numeric($lot['bid_step']) || intval($lot['bid_step']) <= 0)) {
        $errors['bid_step'] = 'Введите число больше 0';
    }
    if (empty($errors['lot_end']) && !is_date_valid($lot['lot_end'])) {
        $errors['lot_end'] = 'Введите дату в формате ГГГГ-ММ-ДД';
    }
    
    $mime_types = ['image/png', 'image/jpeg'];
    if (empty($errors['image']) && !in_array(mime_content_type($_FILES['image']['tmp_name']), $mime_types)) {
        $errors['image'] = 'Загрузите изображение в формате png или jpeg';
    }
    if (empty($errors)) {
    	//сохранить фото в папку арлоадс
    	$lot['owner_id'] = $user_id;
    	//записать в $lot['image'] путь к этому фото
    	//сохранить лот в БД, найти пример в демке
    }
}

$page_content = include_template('add-lot.php', [
    'lots' => $lots,
    'lot' => $lot,
    'errors' => $errors,
    'categories' => $categories
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Добавить лот',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);