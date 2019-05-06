<?php

$con = mysqli_connect ('localhost', 'root', '', '951547-yeticave-9');

if ($con == false) {
	exit ("Ошибка" . mysqli_connect_error($con));
} 

mysqli_set_charset ($con, 'utf8');