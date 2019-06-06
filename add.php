<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

    if (count($_SESSION) < 1) {
    	header("Location: error.php");
    }

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
    	$tmpname = $_FILES['image']['tmp_name'];
    	$filename = 'uploads/' . $_FILES['image']['name'];
        move_uploaded_file($tmpname,  $filename);
    }
    if (empty($errors)) {	
        $lot['owner_id'] = $user_id;
        $lot['image']  = $filename;
    
        $sql = "INSERT INTO `lots` (`title`, `category`, `description`, `image`, `price_start`, `bid_step`, `lot_end`, `owner_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $sql_add = db_get_prepare_stmt($con, $sql, [$lot['title'], $lot['category'], $lot['description'], $lot['image'], $lot['price_start'], $lot['bid_step'], $lot['lot_end'], $lot['owner_id']]);
        $res = mysqli_stmt_execute($sql_add);
    }
    if ($res) {
        $lot_id = mysqli_insert_id($con);

        header("Location: lot.php?id=" . $lot_id);
    }
    


    //else {$content = include_template('error.php', ['error' => mysqli_error($link)]);}
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
    'user_name' => $_SESSION['user']['name']
]);

print($layout_content);