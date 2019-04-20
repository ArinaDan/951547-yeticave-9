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
	//$text = strip_tags($str);

	return $text;
}