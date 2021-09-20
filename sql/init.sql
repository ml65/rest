-- phpMyAdmin SQL Dump
-- version 5.1.1-1.fc34
-- https://www.phpmyadmin.net/
--
-- Хост: 192.168.122.177
-- Время создания: Сен 20 2021 г., 01:31
-- Версия сервера: 8.0.21
-- Версия PHP: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- База данных: `adv`
--

-- --------------------------------------------------------

--
-- Структура таблицы `adv`
--

CREATE TABLE `adv` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `provider_type` enum('individual','entity') DEFAULT NULL,
  `provider_name` varchar(255) NOT NULL,
  `provider_surname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `provider_pathronymic` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `mainimage` varchar(255) NOT NULL,
  `images` text,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `adv`
--
ALTER TABLE `adv`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `adv`
--
ALTER TABLE `adv`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

