CREATE DATABASE yeticave;
/*DEFAULT CHARACTER SET utf8;
DEFAULT COLLATE utf8_general_ci;
Если раскомментировать, то выдает:
Ошибка SQL (1064): You have an error in your SQL syntax; check the manual that corresponds to
your MariaDB server version for the right syntax to use near 'DEFAULT CHARACTER SET utf8' at line 1
*/
USE yeticave;
CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
email CHAR(128) NOT NULL UNIQUE,
`password` CHAR(64) NOT NULL,
`name` CHAR(128) DEFAULT 'Гость',
photo CHAR(255),
contacts CHAR(255),
reg_date TIMESTAMP,
lot_id INT,
bid_id INT
);
CREATE TABLE categories (
id INT AUTO_INCREMENT PRIMARY KEY,
`name` CHAR(64)
);
CREATE TABLE lots (
id INT AUTO_INCREMENT PRIMARY KEY,
title CHAR(255) NOT NULL,
price_start INT NOT NULL,
time_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP, /*значение по умолчанию тут уместно? Оно запишется 1 раз при создании или будет меняться?*/
time_end TIMESTAMP,
image CHAR(255) NOT NULL,
description TEXT,
bid_step INT NOT NULL,
category_id INT,
user_id INT,
user_win_id INT /*в последних трех лучше id или ссылка на профиль/имя категории?*/
);
CREATE TABLE bids (
id INT AUTO_INCREMENT PRIMARY KEY,
amount INT NOT NULL,
`time` TIMESTAMP,
lot_id INT,
user_id INT
);