-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 10 2021 г., 08:37
-- Версия сервера: 5.7.33
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `andreygrom3`
--

-- --------------------------------------------------------

--
-- Структура таблицы `agcms_config`
--

CREATE TABLE `agcms_config` (
  `ID` int(11) NOT NULL,
  `PARAM` varchar(255) NOT NULL,
  `VALUE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `agcms_config`
--

INSERT INTO `agcms_config` (`ID`, `PARAM`, `VALUE`) VALUES
(3, 'SiteTitle', 'Андрей Гром. Сайт разработчика'),
(4, 'Theme', 'default'),
(5, 'ModuleDefault', 'pages'),
(6, 'DefaultMetaDesc', ''),
(7, 'DefaultMetaKeywords', ''),
(59, 'SiteEnabled', '1'),
(64, 'SiteDisabledMessage', 'Извините, на сайте ведутся технические работы. '),
(67, 'MailSMTPEnabled', '0'),
(68, 'MailSMTPHost', 'ssl://smtp.yandex.ru'),
(69, 'MailSMTPPort', '465'),
(70, 'MailSMTPUserName', 'info@andreygrom.ru'),
(71, 'MailSMTPUserPassword', 'Leviafan2016Greh'),
(72, 'MailSMTPFromName', 'Андрей Гром'),
(80, 'SiteDescription', ''),
(81, 'SiteDirector', 'Андрей Гром');

-- --------------------------------------------------------

--
-- Структура таблицы `agcms_pages`
--

CREATE TABLE `agcms_pages` (
  `id` int(3) NOT NULL,
  `parent_id` int(3) NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publ` int(1) NOT NULL,
  `comments` int(1) NOT NULL,
  `template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(3) NOT NULL DEFAULT '0',
  `old` int(3) NOT NULL,
  `release` int(1) NOT NULL,
  `date_create` int(11) NOT NULL,
  `date_edit` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `agcms_pages`
--

INSERT INTO `agcms_pages` (`id`, `parent_id`, `alias`, `title`, `short_content`, `content`, `meta_title`, `meta_desc`, `meta_keywords`, `publ`, `comments`, `template`, `position`, `old`, `release`, `date_create`, `date_edit`, `user_id`, `ip`) VALUES
(1, 0, 'main', 'Главная', '', '', '', '', '', 1, 1, '', 0, 1, 0, 1628412216, 1628412216, 1, 0),
(2, 0, 'main', 'Главная2', '', '', '', '', '', 1, 1, '', 0, 1, 0, 1628412216, 1628412756, 1, 0),
(3, 0, 'main', 'Главная 3', '', '', '', '', '', 1, 1, '', 0, 1, 0, 1628412216, 1628412818, 1, 0),
(4, 0, 'main', 'Главная 4', '', '', '', '', '', 1, 1, '', 0, 1, 0, 1628412216, 1628412885, 1, 0),
(5, 0, 'main', 'Главная 5', '', '', '', '', '', 1, 1, '', 0, 1, 0, 1628412216, 1628412946, 1, 0),
(6, 0, 'main', 'Главная', '', '', '', '', '', 1, 1, '', 0, 1, 1, 1628412216, 1628414722, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `agcms_users`
--

CREATE TABLE `agcms_users` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '4',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `date_create` int(11) NOT NULL,
  `date_active` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `reg_ip` varchar(15) NOT NULL,
  `login_ip` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `agcms_users`
--

INSERT INTO `agcms_users` (`id`, `group_id`, `email`, `password`, `phone`, `hash`, `date_create`, `date_active`, `status`, `reg_ip`, `login_ip`) VALUES
(1, 1, 'grominfo@gmail.com', '73c4ab1d9516475f797c965c12a598d0', '+79608599638', '56n6asE3DKQsFFfzzdQb', 0, 1458588497, 0, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `agcms_users_group`
--

CREATE TABLE `agcms_users_group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `agcms_users_group`
--

INSERT INTO `agcms_users_group` (`group_id`, `group_name`, `group_icon`) VALUES
(1, 'Администратор', '/inc/controllers/register/res/img/admin.gif'),
(2, 'Глобальный модератор', '/inc/controllers/register/res/img/moder.gif'),
(3, 'Модератор', '/inc/controllers/register/res/img/moder.gif'),
(4, 'Пользователь', '/inc/controllers/register/res/img/bullet_user.png'),
(5, 'Заблокирован', '/inc/controllers/register/res/img/banned.png'),
(6, 'Лох', '/inc/controllers/register/res/img/alarm_bell.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `agcms_config`
--
ALTER TABLE `agcms_config`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `agcms_pages`
--
ALTER TABLE `agcms_pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `agcms_users`
--
ALTER TABLE `agcms_users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `agcms_users_group`
--
ALTER TABLE `agcms_users_group`
  ADD PRIMARY KEY (`group_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `agcms_config`
--
ALTER TABLE `agcms_config`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT для таблицы `agcms_pages`
--
ALTER TABLE `agcms_pages`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `agcms_users`
--
ALTER TABLE `agcms_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `agcms_users_group`
--
ALTER TABLE `agcms_users_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
