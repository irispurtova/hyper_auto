-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 03 2024 г., 17:29
-- Версия сервера: 8.0.30
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `auto`
--

-- --------------------------------------------------------

--
-- Структура таблицы `account`
--

CREATE TABLE `account` (
  `1` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `telephone` bigint NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `account`
--

INSERT INTO `account` (`1`, `login`, `name`, `telephone`, `email`, `address`) VALUES
(1, 'user', 'Иван Иванов', 89856486532, 'ivanivanov@mail.ru', 'г. Санкт-Петербург, ул. Двинская, д.5/7');

-- --------------------------------------------------------

--
-- Структура таблицы `all_orders`
--

CREATE TABLE `all_orders` (
  `id_order` int NOT NULL,
  `id_user` int NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_tel` bigint NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `total` bigint NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `all_orders`
--

INSERT INTO `all_orders` (`id_order`, `id_user`, `user_name`, `user_tel`, `user_email`, `user_address`, `total`, `status`) VALUES
(4, 1, 'Иван Иванов', 89856486532, 'ivanivanov@mail.ru', 'г. Санкт-Петербург, ул. Двинская, д.5/7', 1777, 4),
(5, 0, '123', 213, 'e@sfd.ru', '1313123123', 1437, 1),
(6, 0, '1', 2, 'eee2STSRT.FH', '334344', 579, 1),
(7, 1, 'Иван Иванов', 89856486532, 'ivanivanov@mail.ru', 'г. Санкт-Петербург, ул. Двинская, д.5/7', 2186, 2),
(8, 0, 'пися', 7894561256, 'eee2STSRT.FH', 'спб', 5530, 1),
(9, 1, 'Иван Иванов', 7777777, 'ivanivanov@mail.ru', 'г. Санкт-Петербург, ул. Двинская, д.5/7', 879, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `cat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `cat_name`) VALUES
(1, 'Автотовары'),
(2, 'Автозапчасти'),
(3, 'Шины'),
(4, 'Масла и смазки'),
(5, 'Аккумуляторы');

-- --------------------------------------------------------

--
-- Структура таблицы `class`
--

CREATE TABLE `class` (
  `id_class` int NOT NULL,
  `id_subcat` int NOT NULL,
  `name_class` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `class`
--

INSERT INTO `class` (`id_class`, `id_subcat`, `name_class`) VALUES
(1, 1, 'Незамерзайка для омывателя'),
(2, 1, 'Щетки и скребки для снега'),
(3, 1, 'Лопаты снеговые'),
(4, 1, 'Чехлы с подогревом'),
(5, 1, 'Обогреватели в салон'),
(6, 2, 'Буксировочный тросы и стопы'),
(9, 13, '123'),
(10, 21, 'erererer');

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE `feedback` (
  `id_fb` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `plus` varchar(255) NOT NULL,
  `minus` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `ev` int NOT NULL,
  `id_prod` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `feedback`
--

INSERT INTO `feedback` (`id_fb`, `name`, `plus`, `minus`, `text`, `ev`, `id_prod`) VALUES
(4, 'я', 'нет', 'все плохо', 'Резкость запаха явно преувеличена производителем, видимо для того, чтобы разница между ожидаемым запахом и тем, как эта жидкость пахнет в реальности, приятно удивила покупателя. &laquo;Омывайка&raquo; реально качественная. Даже при сильно загрязнённом лобовом стекле, достаточно одного короткого 1-2 секунды нажатия на рычаг подачи омывающей жидкости, для того, чтобы помочь &laquo;дворникам&raquo; качественно очистить лобовое стекло. При минусовых температурах ведёт себя гораздо лучше чем жидкости продающиеся на обочинах дорог. Раньше ими только и пользовался, не понимая зачем переплачивать. Попользовался &laquo;омывайкой&raquo; о которой пишу отзыв, понял, смысл переплатить (по сравнению с той, что на обочине) есть. Реально ниже порог замерзания, качественно удаляет грязь, экономна в использовании.', 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id_img` int NOT NULL,
  `id_product` int NOT NULL,
  `source` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id_img`, `id_product`, `source`) VALUES
(2, 2, 'images/2.webp'),
(13, 15, 'images/0_ha_product_card_large.webp'),
(14, 16, 'images/tros_orange.webp'),
(15, 17, 'images/0_ha_product_card_large (1).webp'),
(21, 1, 'images/1.webp'),
(35, 43, 'images/sk_mv.ru_project-Fauna-2_photo-3.jpg'),
(36, 44, 'images/sk_mv.ru_project-Fauna-2_variant-2_photo-4.jpg'),
(39, 47, 'images/Снимок экрана 2023-12-01 224456.png'),
(40, 48, 'images/Снимок экрана 2023-12-02 020508.png'),
(41, 49, 'images/Снимок экрана 2023-12-02 020800.png'),
(42, 50, 'images/Снимок экрана 2023-12-03 162017.png'),
(43, 51, 'images/Снимок экрана 2023-12-05 220415.png'),
(44, 52, 'images/Снимок экрана 2023-12-03 150129.png'),
(45, 53, 'images/Снимок экрана 2023-12-05 160243.png'),
(46, 54, 'images/Снимок экрана 2023-12-12 175452.png'),
(47, 55, 'images/Снимок экрана 2023-12-05 214747.png'),
(48, 56, 'images/Снимок экрана 2023-12-12 180503.png');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `id_order` int DEFAULT NULL,
  `id_user` int NOT NULL,
  `id_prod` int NOT NULL,
  `count_prod` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `id_order`, `id_user`, `id_prod`, `count_prod`) VALUES
(3, 4, 1, 1, 2),
(4, 4, 1, 2, 1),
(10, 5, 0, 1, 3),
(11, 6, 0, 16, 1),
(12, 7, 1, 16, 3),
(13, 7, 1, 17, 1),
(14, 8, 0, 17, 2),
(16, 8, 0, 16, 8),
(17, 9, 1, 15, 1),
(18, NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `order_status`
--

CREATE TABLE `order_status` (
  `id` int NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `order_status`
--

INSERT INTO `order_status` (`id`, `status`) VALUES
(1, 'В обработке'),
(2, 'Сборка'),
(3, 'Доставка'),
(4, 'Доставлен');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `subcategory_id` int DEFAULT NULL,
  `id_class` int DEFAULT NULL,
  `article` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `price` mediumint NOT NULL,
  `season` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `category_id`, `subcategory_id`, `id_class`, `article`, `code`, `brand`, `price`, `season`) VALUES
(1, 'Стеклоомывающая жидкость Т-Синтез Чистая миля зимняя, -25°C, с резким запахом, 3.78л', 1, 1, 1, '430406014', '70104', 'Т-СИНТЕЗ', 479, 'yes'),
(2, 'Стеклоомывающая жидкость Лукойл Black Edition, зимняя, -20°C, с эксклюзивным ароматом от ведущих парфюмеров мира, 3.78л', 1, 1, 1, '3343568', 'KQ462', 'ЛУКОЙЛ', 819, 'no'),
(15, 'Стеклоомывающая жидкость Лукойл, зимняя, -30°C, с ароматом бубль гум, 4л', 1, 1, 1, '3099152', 'KL903', 'ЛУКОЙЛ', 879, 'yes'),
(16, 'Трос буксировочный TOP AUTO, строп лента, крюки, нагрузка до 7т, длина 5м', 1, 2, 6, '38642', '14118', 'ТОПАВТО', 579, 'no'),
(17, 'Трос буксировочный АлСиб, строп лента, крюки, нагрузка до 3т, длина 5м', 1, 2, 6, '13201', '13201', 'РОССИЯ', 449, 'no'),
(43, 'лопата', 1, 1, 3, '1', '1', '1', 10, 'yes'),
(44, 'ц', 2, 21, 10, 'ц', 'ц', 'ц', 12, 'no'),
(47, 'товар 1', 1, 1, 1, '1', '1', '1', 1, 'yes'),
(48, 'товар 2', 1, 2, 6, '2', '2', '2', 2, 'yes'),
(49, 'товар 3', 2, 21, 10, '123123', '123', '123', 2222, 'yes'),
(50, 'товар 4', 5, 13, 9, '123', '123', '123', 333, 'yes'),
(51, 'товар 5', 1, 1, 4, '789', '978', '978', 888, 'yes'),
(52, '123123', 1, 2, 6, '123', '123', '1', 1, 'no'),
(53, 'dd', 1, 2, 6, 'd', 'd', 'd', 123, 'no'),
(54, 'jhjdhf', 1, 2, 6, 'df', '12333', '4', 4, 'no'),
(55, '3', 1, 2, 6, '5', '6', '8', 9, 'no'),
(56, 'r', 1, 2, 6, 'r', 'r', 'r', 8, 'no');

-- --------------------------------------------------------

--
-- Структура таблицы `subcategories`
--

CREATE TABLE `subcategories` (
  `id_subcat` int NOT NULL,
  `id_cat` int NOT NULL,
  `subcat_name` varchar(255) NOT NULL,
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `subcategories`
--

INSERT INTO `subcategories` (`id_subcat`, `id_cat`, `subcat_name`, `source`) VALUES
(1, 1, 'Зимние товары', 'images/cat13016_200x200.webp'),
(2, 1, 'Техпомощь в дороге', 'images/cat13006_200x200.webp'),
(3, 1, 'Все для техосмотра', 'images/cat13001_200x200.webp'),
(4, 2, 'Фильтры', 'images/cat13151_200x200.png'),
(5, 2, 'Дворники и детали стеклоочистителей', 'images/cat13152_200x200.webp'),
(6, 2, 'Лампочки и дополнительное освещение', 'images/cat13153_200x200.webp'),
(7, 3, 'Все для шиномоонтажа', 'images/cat13639_200x200.webp'),
(8, 3, 'Пакеты и чехлы для шин', 'images/cat13645_200x200.webp'),
(9, 3, 'Цепи противоскольжения', 'images/cat12918_200x200.webp'),
(10, 4, 'Моторные масла', 'images/cat12910_200x200.webp'),
(11, 4, 'Трансмиссионные масла', 'images/cat12911_200x200.webp'),
(12, 4, 'Все для замены масла', 'images/cat15423_200x200.webp'),
(13, 5, 'Автомобильные аккумуляторы', 'images/cat12919_200x200.webp'),
(14, 5, 'Аккумуляторы для мотоциклов', 'images/cat12920_200x200.webp'),
(15, 5, 'Крепления и клеммы', 'images/cat12921_200x200.webp'),
(21, 2, 'yjdfz', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`) VALUES
(1, 'admin', 'admin'),
(2, 'user', 'user1');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`1`);

--
-- Индексы таблицы `all_orders`
--
ALTER TABLE `all_orders`
  ADD PRIMARY KEY (`id_order`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id_class`),
  ADD KEY `id_subcat` (`id_subcat`);

--
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id_fb`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id_img`),
  ADD KEY `id_product` (`id_product`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_class` (`id_class`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Индексы таблицы `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id_subcat`),
  ADD KEY `id_cat` (`id_cat`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `account`
--
ALTER TABLE `account`
  MODIFY `1` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `all_orders`
--
ALTER TABLE `all_orders`
  MODIFY `id_order` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `class`
--
ALTER TABLE `class`
  MODIFY `id_class` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id_fb` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id_img` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT для таблицы `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id_subcat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `id_subcat` FOREIGN KEY (`id_subcat`) REFERENCES `subcategories` (`id_subcat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `id_product` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `id_class` FOREIGN KEY (`id_class`) REFERENCES `class` (`id_class`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `subcategory_id` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id_subcat`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `id_cat` FOREIGN KEY (`id_cat`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
