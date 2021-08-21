<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{$html_plugins_dir}bootstrap4/css/bootstrap.min.css">
    <link rel="stylesheet" href="{$html_plugins_dir}font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{$theme_dir}css/style.css">
    <title>{$meta_title}</title>
    <meta name="description" content="{$meta_description}">
    <meta name="keywords" content="{$meta_keywords}">
    {*TODO Тут подключить остальные метатеги*}
</head>
<body class="main-page">
<header>
    <nav class="navbar navbar-custom navbar-expand-lg fixed-top" id="navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="{$theme_dir}img/logo.png" alt="{$config->SiteName}"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contacts">Контакты</a>
                    </li>
                </ul>


                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Задать вопрос</button>

            </div>
        </div>
    </nav>
</header>

<section class="s1">
    <h1>Обуздай свой WEB</h1>
    <div class="container sites-items">
        <div class="row">
            <div class="col-sm">
                <div class="sites-item">
                    <p class="sites-item-caption">Одностраничный сайт</p>
                    <div class="sites-item-icon">
                        <img src="{$theme_dir}img/medal.png" alt="">
                    </div>
                    <div class="sites-item-desc">
                        Если у вас есть линейка продуктов или направление деятельности,
                        то без особых затрат можете рассказать об этом и привлечь новых клиентов!
                        <p><a href="#">Подробнее</a></p>

                    </div>
                    <div class="sites-item-price">
                        От 5 000 руб.
                    </div>
                    <p class="sites-item-order">
                        <button class="sites-item-order-btn btn btn-outline-primary btn-block">Заказать</button>
                    </p>
                </div>

            </div>
            <div class="col-sm">
                <div class="sites-item">
                    <p class="sites-item-caption">Сайт-визитка</p>
                    <div class="sites-item-icon">
                        <img src="{$theme_dir}img/medal.png" alt="">
                    </div>
                    <div class="sites-item-desc">
                        У вас есть фирма или бизнес на дому, и вы хотите детально рассказать о своей деятельности?
                        Тогда это вариант точно для вас!
                        <p><a href="#">Подробнее</a></p>
                    </div>
                    <div class="sites-item-price">
                        От 15 000 руб.
                    </div>
                    <p class="sites-item-order">
                        <button class="sites-item-order-btn btn btn-outline-primary btn-block">Заказать</button>
                    </p>
                </div>

            </div>
            <div class="col-sm">
                <div class="sites-item">
                    <p class="sites-item-caption">Интернет-магазин</p>
                    <div class="sites-item-icon">
                        <img src="{$theme_dir}img/medal.png" alt="">
                    </div>
                    <div class="sites-item-desc">
                        Множество людей делают покупки не выходя из дома, и даже вы. Можно продавать свои товары или перепродавать чужие.
                        <p><a href="#">Подробнее</a></p>
                    </div>
                    <div class="sites-item-price">
                        От 30 000 руб.
                    </div>
                    <p class="sites-item-order">
                        <button class="sites-item-order-btn btn btn-outline-primary btn-block">Заказать</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <p>&nbsp;</p>

    <p class="text-center"><a href="#" class="btn-opacity">Посмотреть бюджетные тарифы</a></p>
</section>

<section class="s2">
    <div class="container">
        <h2>Другие наши услуги</h2>
    </div>
</section>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<script type="text/javascript" src="{$html_plugins_dir}jquery/jquery-3.6.0.min.js"></script>
<script src="{$html_plugins_dir}bootstrap4/js/bootstrap.min.js"></script>

<script>
    $(function () {
        if ($(window).width() > 400){
            var el = $("#navbar-custom");
            var elt = el.offset().top  + $(".s2").offset().top ;
            var h = el.height();
            var body_top = $("body").css('padding-top');
            $(window).scroll(function() {
                if ($(this).scrollTop() > 200){
                    el.addClass('navbar-custom-2');
                    $("#top > div").addClass('container');
                    $("#top > div > div").addClass('col-sm-12');
                    $('body').css('padding-top', h);
                } else {
                    el.removeClass('navbar-custom-2');
                    $("#top > div").removeClass('container');
                    $("#top > div > div").removeClass('col-sm-12');
                    $('body').css('padding-top', body_top);
                }
            })
        }

    })
</script>
</body>
</html>