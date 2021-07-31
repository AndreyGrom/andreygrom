<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Панель управления</title>

    <link href="/system/AdminDesign/css/bootstrap.min.css" rel="stylesheet">
    <link href="/system/AdminDesign/css/main.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section id="signin_main" class="authenty signin-main" style="">
    <div class="section-content">
        <div class="wrap">
            <div class="container">
                <div class="form-wrap">
                    <div class="row">
                        <div class="text-center">
                            <h1>Вход в админ панель</h1>
                            <p class="lead">Центр управления AG CMS</p>
                            {$error}
                        </div>
                        <div id="form_1" data-animation="bounceIn" class="animated bounceIn">
                        <form method="post">
                            <div class="form-header">
                                <img src="/system/AdminDesign/img/logo2.png" alt=""/>
                            </div>
                            <div class="form-main">
                                <div class="form-group">
                                    <input type="text" id="un_1" name="user" class="form-control" placeholder="Логин" required="required">
                                    <input type="password" id="pw_1" name="password" class="form-control" placeholder="Пароль" required="required">
                                </div>
                                <button id="signIn_1" type="submit" class="btn btn-block signin">Вход</button>
                            </div>
                            <div class="form-footer">
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="footer text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p>Система управления сайтом AG CMS v. 3.02</p>
                <p>© <a href="http://andreygrom.ru/" style="margin-top: -7px;" data-toggle="tooltip" title="Автор программного кода AG CMS. Перейти на сайт разработчика Андрей Гром. Программирование, и не только..." target="_blank"><img src="http://andreygrom.ru/favicon.ico" style="width:16px;">Андрей Гром</a> Все права защищены!</p>
            </div>
        </div>
    </div>
</section>

<!-- jQuery Version 1.11.1 -->
<script type="text/javascript" src="/system/AdminDesign/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/system/AdminDesign/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</body>

</html>
