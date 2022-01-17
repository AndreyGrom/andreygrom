<form method="post" id="settings-form">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase">
                <span class="glyphicon glyphicon-cog"></span>
                Настройки модуля
            </h3>
        </div>
        <div class="panel-body">
            <div class="form-horizontal" role="form">
                <div class="tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-common" data-toggle="tab">Общее</a></li>
                        <li><a href="#tab-comments" data-toggle="tab">Комментарии</a></li>
                        <li><a href="#tab-seo" data-toggle="tab">SEO</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-common" class="tab-pane fade in active">
                            <h3></h3>
                            <p>{include file="settings-common.tpl"}</p>
                        </div>
                        <div id="tab-seo" class="tab-pane fade">
                            <h3></h3>
                            <p>{include file="settings-seo.tpl"}</p>
                        </div>
                        <div id="tab-comments" class="tab-pane fade">
                            <h3></h3>
                            <p>{include file="settings-comments.tpl"}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" id="save-settings" class="btn btn-dark btn-large">Сохранить</button>
            </div>
        </div>
    </div>
</form>
<script>
    $("#settings-form").submit(function(e){
        $("#save-settings").prepend(img_loader);
        e.preventDefault();
        var $that = $(this),
            formData = new FormData($that.get(0));
        formData.append('action', 'save-settings');
        $.ajax({
            type: "POST",
            data: formData,
            processData : false,
            contentType : false,
            success: function(msg){
                img_loader.remove();
                alert_info("Настройки модуля сохранены");
            }
        });
        return false;
    });
</script>