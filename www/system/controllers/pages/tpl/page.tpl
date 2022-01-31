<form id="page-form" action="" method="post">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase">
                <span class="glyphicon glyphicon-duplicate"></span>
                {if !isset($page)}Создание новой страницы{else}Редактирование страницы{/if}
                {if isset($page) && $page.id > 1}
                    <a href="?c=pages&id={$page.id}&action=remove-page" class="btn btn-danger btn-xs pull-right confirm">
                        <i class="glyphicon glyphicon-remove" aria-hidden="true"></i> Удалить страницу
                    </a>
                {/if}
            </h3>
        </div>
        <div class="panel-body">
            {if isset($page)}
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>URL: <br><a target="_blank" href="{$site_url}{$page.alias}">{$site_url}{$page.alias}</a></td>
                            <td>Дата создания: <br>{$page.date_create|date_format:"%D %T"}</td>
                            <td>Дата изменения: <br>{$page.date_edit|date_format:"%D %T"}</td>
                        </tr>
                    </table>
                <hr/>
            {/if}
            <div class="form-horizontal" role="form">
                <div class="tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-common" data-toggle="tab">Общие</a></li>
                        <li><a href="#tab-content" data-toggle="tab">Контент</a></li>
                        <li><a href="#tab-seo" data-toggle="tab">SEO</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-common" class="tab-pane fade in active">
                            <h3>Общие данные</h3>
                            <p>{include file="page-common.tpl"}</p>
                        </div>
                        <div id="tab-content" class="tab-pane fade">
                            <h3>Контент</h3>
                            <p>{include file="page-content.tpl"}</p>
                        </div>
                        <div id="tab-seo" class="tab-pane fade">
                            <h3>SEO</h3>
                            <p>{include file="page-seo.tpl"}</p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="pull-left">
                    <a href="?c=pages" class="btn btn-default">Отмена</a>
                </div>
                <div class="pull-right">
                    <button type="submit" id="save-page" class="btn btn-dark">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $("#check_alias").click(function (e) {
        e.preventDefault();
        var el = $(this);
        el.prepend(img_loader);
        var data = 'action=check-alias&alias=' + $("#alias").val();
        if (url_var['id'] !== 0){
            data += '&id=' + url_var['id'];
        }
        $.ajax({
            type: "POST",
            data: data,
            success: function(msg){
                img_loader.remove();
                if (msg == 0) msg = "Этот алиас можно использовать";
                alert_info(msg);
            }
        });
    });

    $("#page-form").submit(function(){
         $("#save-page").prepend(img_loader);
        var data = $(this).serialize() + '&action=save-page';
        $.ajax({
            type: "POST",
            data: data,
            success: function(msg){
                img_loader.remove();
                var obj = JSON.parse(msg);
                if (obj.error !== false){
                    alert_info("Ошибка: " + obj.error);
                } else {
                    if (Number(url_var['id']) === 0){
                        document.location.href = "?c=pages&success-save-page&id=" + obj.id;
                    } else {
                        alert_info("Страница успешно обновлена");
                    }
                }
            }
        });
        return false;
    });
    $("#template  option[value='default']").prop('selected', true);

</script>