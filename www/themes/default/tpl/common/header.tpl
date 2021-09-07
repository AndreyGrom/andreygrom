<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="{$theme_dir}img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{$html_plugins_dir}bootstrap4/css/bootstrap.min.css">
    <link rel="stylesheet" href="{$html_plugins_dir}font-awesome-4.7.0/css/font-awesome.min.css">

    {*Эти стили только для главной. Сделать условие*}
    <link rel="stylesheet" href="{$theme_dir}owl/owl.carousel.min.css">
    <link rel="stylesheet" href="{$theme_dir}owl/owl.theme.default.min.css">

    <link rel="stylesheet" href="{$theme_dir}css/style.css">
    <title>{$meta_title}</title>
    <meta name="description" content="{$meta_description}">
    <meta name="keywords" content="{$meta_keywords}">
    {*TODO Тут подключить остальные метатеги*}
</head>
<body class="{$class}">
<div class="wrapper">
<header>
    <nav class="navbar navbar-custom navbar-expand-md fixed-top {if !$home}navbar-custom-fixed-color{/if}" id="navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="{$theme_dir}img/logo.png" alt="{$config->SiteName}"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-md-auto2 justify-content-center">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/services">Услуги</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contacts">Контакты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/catalog">Статьи</a>
                    </li>
                </ul>


                <button data-toggle="modal" data-target="#order-modal" class="btn btn-outline-warning my-2 my-sm-0" type="submit">Сделать заказ</button>

            </div>
        </div>
    </nav>
</header>