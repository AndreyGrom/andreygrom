<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Панель управления содержимым AG CMS">
    <meta name="author" content="Андрей Гром">
    <title>Центр управления AG CMS - {$title}</title>
    <script type="text/javascript" src="{$html_plugins_dir}jquery/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="{$html_plugins_dir}jquery/jquery.cookie.js"></script>
    <script type="text/javascript" src="{$html_plugins_dir}func.js"></script>
    <link rel="stylesheet" href="{$html_plugins_dir}fancybox/jquery.fancybox.min.css">
    <script type="text/javascript" src="{$html_plugins_dir}fancybox/jquery.fancybox.min.js"></script>
    <script src="/system/design/js/bootstrap.min.js"></script>
    <link href="/system/design/css/bootstrap.min.css" rel="stylesheet">
    <link href="/system/design/css/main.css" rel="stylesheet">
    <style>
        body {
            padding-top: 70px;
        }
    </style>
    {$js}
    {$css}
</head>
<body>
<div class="wrapper">
{$widget_head_top}
<nav class="navbar navbar-inverse navbar-black navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Главное меню</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="?"><img style="margin-top: -5px;width: 127px;" src="/system/design/img/logo2.png" alt=""/></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <span class="glyphicon glyphicon-user"></span> Модули <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        {section name=i loop=$modules}
                            {if $modules[i].visible}
                            <li>
                                <a href="?c={$modules[i]['alias']}" class="">
                                    <span class="glyphicon {$modules[i]['icon']}"></span>
                                    {$modules[i]['name']}
                                </a>
                            </li>
                            {/if}
                        {/section}
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <span class="glyphicon glyphicon-user"></span> Инструменты <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="?remove-system-cash" data-toggle="tooltip" data-placement="bottom" title="">
                                <span class="glyphicon glyphicon-trash"></span> Удалить весь кеш
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <span class="glyphicon glyphicon-user"></span> Профиль <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="?c=manual" data-toggle="tooltip" data-placement="bottom"
                               title="Документация для разработчика. Как пользоватся админ-панелью - см. на сайте презентации движка."><span
                                        class="glyphicon glyphicon-list-alt"></span> Документация</a>
                        </li>
                        <li>
                            <a href="?c=support" data-toggle="tooltip" data-placement="bottom"
                               title="Написать письмо разработчику AG Landing Panel"><span
                                        class="glyphicon glyphicon-envelope"></span> Написать разработчику</a>
                        </li>
                        <li>
                            <a href="?c=login&out" data-toggle="tooltip" data-placement="bottom"
                               title="Выйти из панели на страницу входа в админку"><span
                                        class="glyphicon glyphicon-log-out"></span> Выйти из панели</a>
                        </li>
                        <li>
                            <a href="?c=login&out&all" data-toggle="tooltip" data-placement="bottom"
                               title="Выйти из панели на страницу входа в админку"><span
                                        class="glyphicon glyphicon-log-out"></span> Выйти со всех устройств</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                <li>
                    <a target="_blank" href="{$site_url}" data-toggle="tooltip" data-placement="bottom" title="">
                        <span class="glyphicon glyphicon-globe"></span> Перейти на сайт
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li>
                    <a href="#" data-toggle="modal" data-target="#about-agcms" title="">
                        <span class="glyphicon glyphicon-info-sign"></span> AG CMS</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <div class="container content">
        {$widget_head_bottom}
        <div class="row">
            <div class="col-md-4">
                <div class="left-widget">
                    {$widget_left_top}
                </div>
                {section name=i loop=$modules}
                    {if $modules[i].alias != $smarty.get.c}
                        {if $modules[i].visible}
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <i class="glyphicon glyphicon-triangle-right" aria-hidden="true"></i>
                                            <a href="?c={$modules[i]['alias']}" class="">{$modules[i]['name']}</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        {/if}
                    {/if}
                {/section}
                {$widget_left_bottom}
            </div>
            <div class="col-md-8 text-left">
                {$widget_content_top}
                {$content}
                {$widget_content_bottom}
            </div>
        </div>
    </div>

    <section class="footer text-center">
        {$widget_footer_top}
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>Система управления сайтом AG CMS v. 4.0</p>
                    <p><a href="mailto:grominfo@gmail.com" style="margin-top: -7px;" data-toggle="tooltip" title="Автор программного кода AG CMS. Перейти на сайт разработчика Андрей Гром. Программирование, и не только..." target="_blank">Андрей Гром</a> Все права защищены!</p>
                </div>
            </div>
        </div>
    </section>
</div>

{if $alert}
    <div class="alert-message">
        {$alert}
    </div>
    <script>
        {literal}
        $(".alert-message").animate({"top":"0"}).delay(3000).animate({"top":-70});
        {/literal}
    </script>
{/if}
<div id="about-agcms" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Система управления содержимым</h4>
            </div>
            <div class="modal-body">
                <div class="text-center"><img style="display: inline-block" src="/system/design/img/logo2.png" class="img-responsive" alt=""/></div>
                <h4 class="text-center">Индивидуальная система управления содержимым!</h4>
                <div class="alert alert-info">
                    <p class="text-center">Разработчик: <span><a href="mailto:grominfo@gmail.com">Андрей Гром</a></span></p>
                </div>
                <p class="text-center">По всем вопросам обращайтесь по адресу: <a href="mailto:grominfo@gmail.com">grominfo@gmail.com</a></p>
                <p class="text-center">Или звоните по телефону: +7 960 859 96 38</p>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>