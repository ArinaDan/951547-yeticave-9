INSERT INTO `categories` (`name`) VALUES ('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное');
INSERT INTO `lots` (`title`, `price_start`, `lot_end`, `image`, `description`, `bid_step`, `category`, `owner_id`) VALUES 
                ('2014 Rossignol District Snowboard', 10999, '2019-05-01 22:50:00', 'img/lot-1.jpg', 'Сноуборд', 1000, '1', '1'),
                ('DC Ply Mens 2016/2017 Snowboard', 159999, '2019-04-23 17:00:00', 'img/lot-2.jpg', 'Дорогой сноуборд', 15000, '1', '1'),
                ('Крепления Union Contact Pro 2015 года размер L/XL', 8000, '2019-04-22 17:00:00', 'img/lot-3.jpg', 'Хорошие крепления', '200', '2', '2'),
                ('Ботинки для сноуборда DC Mutiny Charocal', 10999, '2019-05-04 16:30:00', 'img/lot-4.jpg', 'Классные ботинки', 300, '3', '3'),
                ('Куртка для сноуборда DC Mutiny Charocal', 7500, '2019-05-10 02:00:00', 'img/lot-5.jpg', 'Теплая куртка', 100, '4', '3'),
                ('Маска Oakley Canopy', 5400, '2019-05-03 12:57:00', 'img/lot-6.jpg', 'Крутая маска', 79, '6', '2');
INSERT INTO `users` (`e-mail`, `password`, `name`, `photo`, `contacts`, `reg_date`) VALUES 
                ('pworlds@bk.ru', 'qwerty', 'Арина', '', 'Россия, 8-912-123-45-67', '2019-04-26 15:44:10'),
                ('cup@mail.ru', '1234', 'Вася', '', 'Россия, 8-922-123-45-67', '2019-04-26 16:00:00'),
                ('nothing@yandex.ru', 'nothing', 'Господин Никто', 'ссылка на фото', 'Россия, 8-933-123-45-67', '2019-04-27 01:07:00');
INSERT INTO `bids` (`price`, `user`, `lot`) VALUES 
                (200000, '1', '2'),
                (6000, '3', '6'),
                (6500, '2', '6');

/* показывает названия категорий */ SELECT `name` FROM `categories`;
/* выбирает активные лоты */ SELECT `title`, `price_start`, `price`, `image`, `name` FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` LEFT JOIN `bids` ON `lot_id` = `lot` WHERE `lot_end` > NOW();
/* выбор одного лота с отображением его категории*/ SELECT * FROM `lots` LEFT JOIN `categories` ON `category` = `category_id` WHERE `lot_id` = 2
/* обновление информации об 1 лоте */ UPDATE `lots` SET `title` = 'Маска Oakley Canopy rare' WHERE `lot_id` = '6'
/* показывает список ставок по лоту */ SELECT `price` FROM `lots` inner JOIN `bids` ON `lot_id` = `lot` WHERE `lot_id` = 6