<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Центр управления AG CMS - {$title}</title>
    <!-- jQuery Version 1.11.1 -->
    <script type="text/javascript" src="{$html_plugins_dir}jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="{$html_plugins_dir}jquery.cookie.js"></script>
    <script type="text/javascript" src="{$html_plugins_dir}func.js"></script>
    <link href="{$html_plugins_dir}fancybox/jquery.fancybox.css" rel="stylesheet">
    <script type="text/javascript" src="{$html_plugins_dir}fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript" src="{$html_plugins_dir}fancybox/jquery.fancybox.pack.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/system/design/js/bootstrap.min.js"></script>
    <!-- Bootstrap Core CSS -->
    <link href="/system/design/css/bootstrap.min.css" rel="stylesheet">
    <link href="/system/design/css/main.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            padding-top: 70px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    {$js}
    {$css}

</head>

<body>
{$widget_head_top}

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Старт главного меню -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Главное меню</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="?"><img style="margin-top: -5px;width: 127px;" src="/system/design/img/logo2.png" alt=""/>
            {*<span class="glyphicon glyphicon-random"></span> AG CMS*}</a>
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
                            <a href="#" onclick="OpenFM()" data-toggle="tooltip" data-placement="bottom" title="">
                                <span class="glyphicon glyphicon-file"></span> Файловый менеджер
                            </a>
                        </li>
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

        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<div id="about-agcms" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Система управления содержимым</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
                 <div class="text-center"><img style="display: inline-block" src="/system/design/img/logo2.png" class="img-responsive" alt=""/></div>
                <h4 class="text-center">Индивидуальная система управления содержимым!</h4>
                <div class="alert alert-info">
                    <p class="text-center">Разработчик: <span><a target="_blank" href="http://andreygrom.ru/"><img style="width:16px;" src="http://andreygrom.ru/favicon.ico"> Андрей Гром</a></span></p>
                </div>
                <p class="text-center">По всем вопросам обращайтесь по адресу: <a href="mailto:grominfo@gmail.com">grominfo@gmail.com</a></p>
                <p class="text-center">Или звоните по телефону: +7 960 859 96 38</p>
            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</div>
{$widget_head_bottom}

<!-- Основной контент -->
<div class="container">

    <div class="row">
        <div class="col-md-4">
            <div class="left-widget">
                {$widget_left_top}
            </div>
            {section name=i loop=$modules}
                {if $modules[i].visible}
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <span class="glyphicon {$modules[i]['icon']}"></span>
                                    <a href="?c={$modules[i]['alias']}" class="">{$modules[i]['name']}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
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
    <!-- /.row -->
</div>
<!-- /.container -->
{$widget_footer_top}
<section class="footer text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p>Система управления сайтом AG CMS v. 3.02</p>
                <p>©
                    <a href="http://andreygrom.ru/" style="margin-top: -7px;" data-toggle="tooltip" title="Автор программного кода AG CMS. Перейти на сайт разработчика Андрей Гром. Программирование, и не только..." target="_blank"><img src="http://andreygrom.ru/favicon.ico" style="width:16px;">Андрей Гром</a>

                    Все права защищены!
                </p>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
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
<script>
   $(".left-widget a[data-toggle='collapse']").click(function(){
       var el = $(this);
       var data_val;
       var data_group = el.attr("aria-controls");
       if (!$("#"+data_group).hasClass('in')){
           data_val = 1;
       } else {
           data_val = 0;
       }
       $.cookie(data_group, data_val, { expires: 360,path: '/'});
    });
   $(".left-widget a[data-toggle='collapse']").each(function(i,elem) {
       var data_group = $(this).attr("aria-controls");
       if  ($.cookie(data_group)){
           if ($.cookie(data_group)==1){
               $("#"+data_group).addClass('in');
           } else {
               $("#"+data_group).removeClass('in');
           }
       }
   });
    function OpenFM(){
        window.open('/filemanager/dialog.php?type=2&popup=1' ,  "rfm_cleditr",
                "status=0, toolbar=0, location=0, menubar=0, directories=0, " +
                        "resizable=0, scrollbars=0, width=900, height=600");
    }

</script>
</body>

</html>