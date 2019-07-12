-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: db
-- Время создания: Июл 12 2019 г., 14:08
-- Версия сервера: 10.3.16-MariaDB-1:10.3.16+maria~bionic
-- Версия PHP: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `phone-book`
--

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `ID` int(11) NOT NULL COMMENT 'id',
  `USER_ID` int(11) NOT NULL COMMENT 'id пользователя fk users',
  `FIRST_NAME` varchar(255) NOT NULL COMMENT 'Имя',
  `LAST_NAME` varchar(255) DEFAULT NULL COMMENT 'Фамилия',
  `PHONE` varchar(255) NOT NULL COMMENT 'телефон',
  `EMAIL` varchar(255) DEFAULT NULL COMMENT 'емейл',
  `PHOTO` varchar(255) DEFAULT NULL COMMENT 'фото'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='таблица записей телефонной книги';

--
-- Дамп данных таблицы `contacts`
--

INSERT INTO `contacts` (`ID`, `USER_ID`, `FIRST_NAME`, `LAST_NAME`, `PHONE`, `EMAIL`, `PHOTO`) VALUES
(1, 2, 'Test', '', '+7(963)081-81-96', '', 'a162f286d4e68c35e8aa2ebe6d4b39ce.jpg'),
(2, 2, 'Никита', 'Трегубов', '895151123651', 'test@mail.test1', 'ac7941917b53df5fd5e3805d82cd4067.jpg'),
(3, 3, 'вася', 'Сергеев', '999999999999', '123@a.ru', '2eb4df9b4da31eec2bb72178a4789b75.jpg'),
(4, 3, 'Олег', 'Дубов', '7951234578', '', NULL),
(5, 4, '1', '1', '9517777484', '', NULL),
(6, 2, '1', '', '1', '', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL COMMENT 'id',
  `NAME` varchar(255) NOT NULL COMMENT 'имя пользователя',
  `LOGIN` varchar(255) NOT NULL COMMENT 'логин',
  `PASSWORD` varchar(255) NOT NULL COMMENT 'пароль'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='таблица пользователей';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `NAME`, `LOGIN`, `PASSWORD`) VALUES
(2, 'Кирилл', 'sema', 'e31023486fa7f6a1d569f84296964821ce6377a4'),
(3, 'Василий', 'vasiliy', '485be412ecd8ad76556c2fb4f65d3f218c9c9768'),
(4, 'Вася', '123456', '29ff8ac98034841046d78785637d6d78225c92df');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `LOGIN` (`LOGIN`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
