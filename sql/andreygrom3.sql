-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 08 2021 г., 00:17
-- Версия сервера: 5.7.33
-- Версия PHP: 7.4.21

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
  `id` int(11) NOT NULL,
  `param` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `agcms_config`
--

INSERT INTO `agcms_config` (`id`, `param`, `value`, `desc`) VALUES
(3, 'SiteTitle', 'Андрей Гром. Сайт разработчика', 'String. Title страницы по умолчанию. Добавляется в конец заголовка'),
(4, 'Theme', 'default', 'String. Название активной темы'),
(5, 'ModuleDefault', 'pages', 'String. Модуль на главной странице. По умолчанию pages (страницы сайта)'),
(6, 'DefaultMetaDesc', '', 'String. Значение тега meta-description по-умолчанию'),
(7, 'DefaultMetaKeywords', '', 'String. Значение тега meta-keywords по-умолчанию'),
(59, 'SiteEnabled', '1', 'Int или boolean. Отключает или включает сайт'),
(64, 'SiteDisabledMessage', 'Извините, на сайте ведутся технические работы. ', 'String. Сообщение, которое выводится при отключенном сайте.'),
(67, 'MailSMTPEnabled', '0', ''),
(68, 'MailSMTPHost', 'ssl://smtp.yandex.ru', ''),
(69, 'MailSMTPPort', '465', ''),
(70, 'MailSMTPUserName', 'infogrom1983@yandex.ru', ''),
(71, 'MailSMTPUserPassword', 'ipexwnzwxfkokaon', ''),
(72, 'MailSMTPFromName', 'Андрей Гром', ''),
(80, 'SiteDescription', '', 'Описание сайта'),
(83, 'SiteDirector', 'Андрей Гром', 'Владелец сайта'),
(84, 'MailFromName', 'Андрей Гром', ''),
(85, 'MailFromEmail', 'grominfo@gmail.com', '');

-- --------------------------------------------------------

--
-- Структура таблицы `agcms_mailforms`
--

CREATE TABLE `agcms_mailforms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emails` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` int(11) NOT NULL,
  `date_edit` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `agcms_mailforms`
--

INSERT INTO `agcms_mailforms` (`id`, `name`, `desc`, `answer`, `template`, `emails`, `date_create`, `date_edit`, `user_id`, `ip`) VALUES
(2, 'Сделать заказ', 'Заказ сайта или услуги', 'Спасибо за заказ. Мы с вами свяжемся в самое ближайшее время', 'vertical.tpl', 'grominfo@gmail.com,grominfo@yandex.ru', 1630945751, 1631026115, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `agcms_mailforms_fields`
--

CREATE TABLE `agcms_mailforms_fields` (
  `id` int(3) NOT NULL,
  `form_id` int(3) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `values` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `placeholder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `agcms_mailforms_fields`
--

INSERT INTO `agcms_mailforms_fields` (`id`, `form_id`, `name`, `type`, `values`, `placeholder`, `required`) VALUES
(3, 2, 'Что хотите заказать', 'select', 'Одностраничный сайт\r\nСайт-визитка\r\nИнтернет-магазин\r\nПеренос сайта\r\nРегистрация домена\r\nКонсультация\r\nДругое', '', 1),
(4, 2, 'Ваше имя', 'text', '', '', 1),
(5, 2, 'Ваш e-mail', 'email', '', '', 1),
(6, 2, 'Сообщение', 'textarea', '', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `agcms_mailforms_messages`
--

CREATE TABLE `agcms_mailforms_messages` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` int(11) NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `agcms_mailforms_messages`
--

INSERT INTO `agcms_mailforms_messages` (`id`, `form_id`, `body`, `date`, `ip`) VALUES
(1, 2, 'Что хотите заказать : Одностраничный сайт\r\n\r\nВаше имя : Andrey Grom\r\nВаш e-mail : grominfo@gmail.com\r\nСообщение : Hello', 1631043032, '127.0.0.1');

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
  `date_create` int(11) NOT NULL,
  `date_edit` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `agcms_pages`
--

INSERT INTO `agcms_pages` (`id`, `parent_id`, `alias`, `title`, `short_content`, `content`, `meta_title`, `meta_desc`, `meta_keywords`, `publ`, `comments`, `template`, `position`, `date_create`, `date_edit`, `user_id`, `ip`, `views`) VALUES
(1, 0, 'main', 'Главная', '<p>1</p>', '<p>2</p>', '', '', '', 1, 0, 'main', 0, 1628412216, 1628412216, 1, 0, 118),
(7, 0, 'contacts', 'Контакты', '', '', '', '', '', 1, 0, 'contacts', 0, 1629670967, 1629670967, 1, 0, 3),
(10, 0, 'ag-cms', 'AG CMS', '', '', '', '', '', 1, 1, 'default', 0, 1631048260, 1631048260, 1, 0, 0);

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
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `agcms_mailforms`
--
ALTER TABLE `agcms_mailforms`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `agcms_mailforms_fields`
--
ALTER TABLE `agcms_mailforms_fields`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `agcms_mailforms_messages`
--
ALTER TABLE `agcms_mailforms_messages`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT для таблицы `agcms_mailforms`
--
ALTER TABLE `agcms_mailforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `agcms_mailforms_fields`
--
ALTER TABLE `agcms_mailforms_fields`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `agcms_mailforms_messages`
--
ALTER TABLE `agcms_mailforms_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `agcms_pages`
--
ALTER TABLE `agcms_pages`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
