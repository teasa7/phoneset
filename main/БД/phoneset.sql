-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 24 2021 г., 20:09
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `phoneset`
--

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE `brands` (
  `ID` int(11) NOT NULL,
  `brand` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE `countries` (
  `ID` int(11) NOT NULL,
  `country` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
--

CREATE TABLE `favorites` (
  `ID` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `ID_product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `ID` int(11) NOT NULL,
  `ID_product` int(11) NOT NULL,
  `image` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `images_reviews`
--

CREATE TABLE `images_reviews` (
  `ID` int(11) NOT NULL,
  `ID_reviews` int(11) NOT NULL,
  `image_review` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `models`
--

CREATE TABLE `models` (
  `ID` int(11) NOT NULL,
  `ID_brand` int(11) NOT NULL,
  `model` varchar(256) NOT NULL,
  `year_release` year(4) NOT NULL,
  `ID_country` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `ID_products` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `payment` varchar(50) NOT NULL,
  `date_order` date NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `status_price` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `ID_model` int(11) NOT NULL,
  `weight` int(50) DEFAULT NULL,
  `price` int(100) NOT NULL,
  `discount` int(10) DEFAULT NULL,
  `date_price` date NOT NULL,
  `orders` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `ID` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `ID_product` int(11) NOT NULL,
  `question` varchar(200) NOT NULL,
  `ID_topics` int(11) NOT NULL,
  `answer` varchar(200) DEFAULT NULL,
  `date_question` date NOT NULL,
  `date_answer` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `ID` int(11) NOT NULL,
  `ID_orders` int(11) NOT NULL,
  `ID_products` int(11) NOT NULL,
  `dignity` varchar(100) DEFAULT NULL,
  `limitations` varchar(100) DEFAULT NULL,
  `text` varchar(300) DEFAULT NULL,
  `grade` int(10) NOT NULL,
  `date_creation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `specifications`
--

CREATE TABLE `specifications` (
  `ID` int(11) NOT NULL,
  `ID_ptoduct` int(11) NOT NULL,
  `guarantee` int(10) DEFAULT NULL,
  `back_color` varchar(50) NOT NULL,
  `front_color` varchar(50) DEFAULT NULL,
  `edge_color` varchar(50) NOT NULL,
  `sim_format` varchar(50) NOT NULL,
  `count_sim` int(10) NOT NULL,
  `screen_diagonal` double NOT NULL,
  `screen_resolution` varchar(50) NOT NULL,
  `body_material` varchar(50) NOT NULL,
  `OS_version` varchar(50) DEFAULT NULL,
  `processor_model` varchar(50) DEFAULT NULL,
  `count_cores` int(10) DEFAULT NULL,
  `battery` varchar(50) NOT NULL,
  `RAM` int(10) NOT NULL,
  `built_in` int(10) NOT NULL,
  `type_cards` varchar(50) DEFAULT NULL,
  `count_cameras` int(10) NOT NULL,
  `main_camera` int(10) NOT NULL,
  `front_camera` int(10) NOT NULL,
  `Bluetooth` varchar(50) DEFAULT NULL,
  `Wi_fi` varchar(50) DEFAULT NULL,
  `NFS` varchar(50) DEFAULT NULL,
  `wire_type` varchar(50) DEFAULT NULL,
  `equipment` varchar(100) DEFAULT NULL,
  `width` double DEFAULT NULL,
  `height` double DEFAULT NULL,
  `thickness` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `topics_questions`
--

CREATE TABLE `topics_questions` (
  `ID` int(11) NOT NULL,
  `topic_question` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `user_photo` longblob DEFAULT NULL,
  `email` varchar(256) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `password` varchar(500) NOT NULL,
  `right` varchar(50) NOT NULL,
  `registration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Favorites_User` (`ID_user`),
  ADD KEY `FK_Favorites_Product` (`ID_product`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Images_Product` (`ID_product`);

--
-- Индексы таблицы `images_reviews`
--
ALTER TABLE `images_reviews`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Images_Review` (`ID_reviews`);

--
-- Индексы таблицы `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Models_Brand` (`ID_brand`),
  ADD KEY `FK_Models_Country` (`ID_country`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Orders_User` (`ID_user`),
  ADD KEY `FK_Orders_Product` (`ID_products`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Product_Model` (`ID_model`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Questions_Product` (`ID_product`),
  ADD KEY `FK_Questions_User` (`ID_user`),
  ADD KEY `FK_Questions_Topic` (`ID_topics`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Reviews_Product` (`ID_products`),
  ADD KEY `FK_Reviews_Order` (`ID_orders`);

--
-- Индексы таблицы `specifications`
--
ALTER TABLE `specifications`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Specification_Product` (`ID_ptoduct`);

--
-- Индексы таблицы `topics_questions`
--
ALTER TABLE `topics_questions`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `favorites`
--
ALTER TABLE `favorites`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `images_reviews`
--
ALTER TABLE `images_reviews`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `models`
--
ALTER TABLE `models`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `specifications`
--
ALTER TABLE `specifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `topics_questions`
--
ALTER TABLE `topics_questions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `FK_Favorites_Product` FOREIGN KEY (`ID_product`) REFERENCES `products` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Favorites_User` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_Images_Product` FOREIGN KEY (`ID_product`) REFERENCES `products` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `images_reviews`
--
ALTER TABLE `images_reviews`
  ADD CONSTRAINT `FK_Images_Review` FOREIGN KEY (`ID_reviews`) REFERENCES `reviews` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `FK_Models_Brand` FOREIGN KEY (`ID_brand`) REFERENCES `brands` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Models_Country` FOREIGN KEY (`ID_country`) REFERENCES `countries` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_Orders_Product` FOREIGN KEY (`ID_products`) REFERENCES `products` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Orders_User` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_Product_Model` FOREIGN KEY (`ID_model`) REFERENCES `models` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FK_Questions_Product` FOREIGN KEY (`ID_product`) REFERENCES `products` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Questions_Topic` FOREIGN KEY (`ID_topics`) REFERENCES `topics_questions` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Questions_User` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_Reviews_Order` FOREIGN KEY (`ID_orders`) REFERENCES `orders` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Reviews_Product` FOREIGN KEY (`ID_products`) REFERENCES `products` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `specifications`
--
ALTER TABLE `specifications`
  ADD CONSTRAINT `FK_Specification_Product` FOREIGN KEY (`ID_ptoduct`) REFERENCES `products` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
