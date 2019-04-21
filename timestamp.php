<?php
date_default_timezone_set("Asia/Yekaterinburg");
setlocale(LC_ALL, 'ru_RU');

/**
* Считает время до завершения лота
* @param string $lot_end
* @return string
*/

function get_formatted_lot_end(string $lot_end) : string
{
    $end = strtotime($lot_end); // YYYY-mm-dd H:i

    $diff = $end - time();
    
    $hours = floor($diff / 3600);
    $minutes = floor($diff % 3600 / 60);
    
    if ($hours < 10) {
        $hours = '0' . $hours;
    }
    if ($minutes < 10) {
        $minutes = '0' . $minutes;
    }
    
    return $hours . ':' . $minutes;
}

/**
* Добавляет класс при выполнении условия
* @param string $lot_end
* @return string
*/
function add_lot_status_class(string $lot_end) : string
{
    $end = strtotime($lot_end); // YYYY-mm-dd H:i

    $diff = $end - time();
    
    return $diff <= 3600 ? 'timer--finishing' : '';
}