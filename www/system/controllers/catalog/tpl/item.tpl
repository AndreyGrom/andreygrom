<form method="post" id="item-form">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase">
                <span class="glyphicon glyphicon-pencil"></span>
                {if !isset($item)}
                    Создание нового материала
                {else}
                    Редактирование материала
                {/if}
            </h3>
        </div>
        <div class="panel-body">
            {if isset($item)}
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>URL: <br><a target="_blank" href="{$site_url}{$module_config.alias}/{$item.alias}">{$site_url}{$module_config.alias}/{$item.alias}</a>
                        </td>
                        <td>Дата создания: <br>{$item.date_publ|date_format:"%D %T"}</td>
                        <td>Дата изменения: <br>{$item.date_edit|date_format:"%D %T"}</td>
                    </tr>
                </table>
                <hr/>
            {/if}
            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-common" data-toggle="tab">Общие</a></li>
                    <li><a href="#tab-content" data-toggle="tab">Содержимое</a></li>
                    <li><a href="#tab-price" data-toggle="tab">Цены</a></li>
                    <li><a href="#tab-images" data-toggle="tab">Изображения</a></li>
                    <li><a href="#tab-files" data-toggle="tab">Файлы</a></li>
                    <li><a href="#tab-seo" data-toggle="tab">SEO</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-common" class="tab-pane fade in active">
                        <h3>Общие данные</h3>
                        <p>{include file="item-common.tpl"}</p>
                    </div>
                    <div id="tab-content" class="tab-pane fade">
                        <h3></h3>
                        <p>{include file="item-content.tpl"}</p>
                    </div>
                    <div id="tab-price" class="tab-pane fade">
                        <h3></h3>
                        <p>{include file="item-price.tpl"}</p>
                    </div>
                    <div id="tab-images" class="tab-pane fade">
                        <h3></h3>
                        <p>{include file="item-images.tpl"}</p>
                    </div>
                    <div id="tab-files" class="tab-pane fade">
                        <h3></h3>
                        <p>{include file="item-files.tpl"}</p>
                    </div>

                    <div id="tab-seo" class="tab-pane fade">
                        <h3></h3>
                        <p>{include file="item-seo.tpl"}</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="pull-left">
                <a href="?c={$module_config.alias}" class="btn btn-default">Отмена</a>
            </div>
            <div class="pull-right">
                <button type="submit" name="save-item" id="save-item" class="btn btn-dark">Сохранить</button>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="{$html_controllers_dir}images/upload.js"></script>
<script type="text/javascript" src="{$html_controllers_dir}files/upload.js"></script>
<script>
    $('#upload-images').upload({
        id: url_var['material_id'],
    });
    $('#upload-files').upload_files({
        id: url_var['material_id'],
    });
</script>
<script type="text/javascript" src="{$html_plugins_dir}init_mce.js"></script>
<script>
    $("#check_alias").click(function (e) {
        e.preventDefault();
        var el = $(this);
        el.prepend(img_loader);
        var data = 'action=check-alias-item&alias=' + $("#alias").val();
        if (url_var['material_id'] !== 0){
            data += '&id=' + url_var['material_id'];
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

    $("#item-form").submit(function(e){
        $("#save-item").prepend(img_loader);
        e.preventDefault();
        var $that = $(this),
            formData = new FormData($that.get(0));
        formData.append('action', 'save-item');
        formData.append('short_content', tinyMCE.get('short_content').getContent());
        formData.append('content', tinyMCE.get('content').getContent());
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
                    document.location.href = "?c={$module_config.alias}&success=save-item&material_id=" + msg.id;
                }
            }
        });
        return false;
    });


    $(function(){
        $('.image-list').on('click', '.remove-image-item', function(e) {
            e.preventDefault();
            RemoveImage($(this).attr('data-id'), $(this).closest('li'), '{$module_config.alias}');
        });
        $('.image-list').on('click', '.skin-image-item', function(e) {
            e.preventDefault();
            SkinImage($(this).attr('data-id'), url_var['material_id'], url_var['c'], 'agcms_catalog_i', $(".image-list .skin-image-item"), $(this));
        });
        $('.file-list').on('click', '.remove-file-item', function(e) {
            e.preventDefault();
            RemoveFile($(this).attr('data-id'), $(this).closest('li'), '{$module_config.alias}');
        });
    });

    $("#template  option[value='default']").prop('selected', true);
</script>
