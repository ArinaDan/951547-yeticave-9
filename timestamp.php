<?php
date_default_timezone_set("Asia/Yekaterinburg");
setlocale(LC_ALL, 'ru_RU');

$ts_now = time();
$ts_end = strtotime('tomorrow');
$ts_interval = $ts_end - $ts_now;
$time_until_end_h = floor($ts_interval / 3600);
$time_until_end_m = floor($ts_interval % 3600 / 60);
//$time_format = $time_until_end_h . ':' . $time_until_end_m;
$time_format = date('H:i', $ts_interval);

print($time_format);