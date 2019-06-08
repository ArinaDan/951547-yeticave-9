<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();

if (!isset($_GET['id'])) {

header('Location: error.php');

}

$lot_id = (int) /*преобразование к числу*/ $_GET['id'];

$categories = get_all_categories($con);
$lots = get_all_lots($con);
$lot_bids = get_all_lot_bids($con, $lot_id);

$sql_lot = "SELECT `lots`.*, MAX(price) as `price`,  `name` as `category_name` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` WHERE `lot_id` = {$lot_id} GROUP BY `lot_id` ORDER BY `lot_add` DESC";
$result_lot = mysqli_query($con, $sql_lot);
$lot = mysqli_fetch_assoc($result_lot); // перенести в функции?

if (empty($lot)) {

header('Location: error.php');

}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
       $bid = $_REQUEST['price'];
       //$user_id = $_SESSION['user']['user_id'];
       //$id = $_REQUEST['id']; 

    //проверка обязательных полей
    if (!isset($bid)) {
    		$error = 'Заполните поле';
    	}
    // правильность заполнения
    if (get_min_bid($lot) > $bid) {
        $error = 'Ваша ставка не может быть меньше минимальной';
    }
    if (!isset($error)) {
$sql = "INSERT INTO `bids` (`price`, `user`, `lot`) VALUES (?, ?, ?)";
$sql_add = db_get_prepare_stmt($con, $sql, [$_REQUEST['price'], $_SESSION['user']['user_id'], $_REQUEST['id']]);
        $res = mysqli_stmt_execute($sql_add);
    }
}
    if ($res) {
        header("Location: lot.php?id=" . $lot_id);
    }


$page_content = include_template('lot.php', [
    'lot' => $lot,
    'lots' => $lots,
    'lot_id' => $lot_id,
    'categories' => $categories,
    'lot_bids' => $lot_bids,
    'lot_bid' => $lot_bid,
    'bid' => $bid,
    'error' => $error
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $lots[$lot_id]['title'],
    'user_name' => $_SESSION['user']['name']
]);

print($layout_content);