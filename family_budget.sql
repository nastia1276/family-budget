-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Гру 30 2023 р., 16:28
-- Версія сервера: 10.4.32-MariaDB
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `family_budget`
--

-- --------------------------------------------------------

--
-- Структура таблиці `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `sum` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `user` int(11) NOT NULL,
  `approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `expenses`
--

INSERT INTO `expenses` (`id`, `category`, `sum`, `date`, `user`, `approved`) VALUES
(3, 'food', 45.00, '2023-12-30', 17, 1);

-- --------------------------------------------------------

--
-- Структура таблиці `family_members`
--

CREATE TABLE `family_members` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `family_members`
--

INSERT INTO `family_members` (`user_id`, `name`, `surname`, `age`, `username`, `password`, `role`) VALUES
(17, 'Антон', 'Ващук', 35, 'anton', 'asdf', 'головний'),
(18, 'Віра', 'Ващук', 18, 'asdf', 'asdf', 'дочка'),
(19, 'May', 'Martin', 20, 'admin', 'maya', 'дочка');

-- --------------------------------------------------------

--
-- Структура таблиці `income`
--

CREATE TABLE `income` (
  `id` int(11) NOT NULL,
  `source` varchar(50) NOT NULL,
  `sum` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `income`
--

INSERT INTO `income` (`id`, `source`, `sum`, `date`, `user`) VALUES
(17, 'ntcn', 234.00, '2023-12-22', 17);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_exp_id` (`user`);

--
-- Індекси таблиці `family_members`
--
ALTER TABLE `family_members`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Індекси таблиці `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_inc_id` (`user`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблиці `family_members`
--
ALTER TABLE `family_members`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблиці `income`
--
ALTER TABLE `income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `fk_exp_id` FOREIGN KEY (`user`) REFERENCES `family_members` (`user_id`);

--
-- Обмеження зовнішнього ключа таблиці `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `fk_inc_id` FOREIGN KEY (`user`) REFERENCES `family_members` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
