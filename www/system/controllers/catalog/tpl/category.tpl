<form id="category-form" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase">
                <span class="glyphicon glyphicon-pencil"></span>
                {if !$item}
                    Создание новой категории
                {else}
                    Редактирование категории
                    <a href="?c={$module_config.alias}&category_id={$item.id}&action=remove-category"
                       class="btn btn-danger btn-xs pull-right confirm">
                        <i class="glyphicon glyphicon-remove" aria-hidden="true"></i> Удалить категорию
                    </a>
                {/if}
            </h3>
        </div>
        <div class="panel-body">
            {if $item}
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>URL: <br><a target="_blank" href="{$site_url}{$module_config.alias}/{$item.alias}">{$site_url}{$module_config.alias}/{$item.alias}</a>
                        </td>
                        <td>Дата создания: <br>{$item.date_create|date_format:"%D %T"}</td>
                        <td>Дата изменения: <br>{$item.date_edit|date_format:"%D %T"}</td>
                    </tr>
                </table>
                <hr/>
            {/if}
            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-common" data-toggle="tab">Общие</a></li>
                    <li><a href="#tab-content" data-toggle="tab">Контент</a></li>
                    <li><a href="#tab-seo" data-toggle="tab">SEO</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-common" class="tab-pane fade in active">
                        <h3>Общие данные</h3>
                        <p>{include file="category-common.tpl"}</p>
                    </div>
                    <div id="tab-content" class="tab-pane fade">
                        <h3>Контент</h3>
                        <p>{include file="category-content.tpl"}</p>
                    </div>
                    <div id="tab-seo" class="tab-pane fade">
                        <h3>SEO</h3>
                        <p>{include file="category-seo.tpl"}</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="pull-left">
                <a href="?c={$module_config.alias}" class="btn btn-default">Отмена</a>
            </div>
            <div class="pull-right">
                <button type="submit" name="save-category" id="save-category" class="btn btn-dark">Сохранить</button>
            </div>
        </div>
    </div>
</form>
<script>
    $("#check_alias").click(function (e) {
        e.preventDefault();
        var el = $(this);
        el.prepend(img_loader);
        var data = 'action=check-alias-category&alias=' + $("#alias").val();
        if (url_var['category_id'] !== 0){
            data += '&id=' + url_var['category_id'];
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

    $("#category-form").submit(function(e){
        $("#save-category").prepend(img_loader);
        e.preventDefault();
        var $that = $(this),
            formData = new FormData($that.get(0));
        formData.append('action', 'save-category');
        formData.append('desc1', tinyMCE.get('desc1').getContent());
        formData.append('desc2', tinyMCE.get('desc2').getContent());
        $.ajax({
            type: "POST",
            data: formData,
            processData : false,
            contentType : false,
            success: function(msg){
                img_loader.remove();
                msg = JSON.parse(msg);
                if (msg.error !== false){
                    alert_info("Ошибка: " + msg.error);
                } else {
                    document.location.href = "?c={$module_config.alias}&success=save-category&category_id=" + msg.id;
                }
            }
        });
        return false;
    });
    $("#template  option[value='default']").prop('selected', true);

</script>