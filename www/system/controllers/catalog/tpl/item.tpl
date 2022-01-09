<form method="post" enctype="multipart/form-data">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase">
                <span class="glyphicon glyphicon-duplicate"></span>
                {if !$item}
                    Создание нового материала
                {else}
                    Редактирование материала
                {/if}
            </h3>
        </div>
        <div class="panel-body">
            {if $item}
                <div class="alert alert-info">
                    <div class="row">
                        <span class="col-sm-3 text-right">URL материала:</span>
                        <span class="col-sm-9"><a target="_blank" href="{$site_url}catalog/{$item_alias}">{$site_url}catalog/{$item_alias}</a></span>
                    </div>
                    <div class="row">
                        <span class="col-sm-3 text-right">Короткая ссылка:</span>
                        <span class="col-sm-9"><a target="_blank" href="{$site_url}catalog/{$item_id}">{$site_url}catalog/{$item_id}</a></span>
                    </div>
                </div>
            {/if}
            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-common" data-toggle="tab">Общие</a></li>
                    <li><a href="#tab-content" data-toggle="tab">Содержимое</a></li>
                    <li><a href="#tab-images" data-toggle="tab">Изображения</a></li>
                    <li><a href="#tab-files" data-toggle="tab">Файлы</a></li>
                    <li><a href="#tab-seo" data-toggle="tab">SEO</a></li>

                    <li><a href="#tab-other" data-toggle="tab">Другое</a></li>
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
        </div>
    </div>
</form>
<script type="text/javascript" src="{$html_plugins_dir}init_mce.js"></script>
<script>

    var alias_page_new = false;
    if ($("#alias").val()==''){
        alias_page_new = true;
    }
    $("#title").change(function(){
        if (alias_page_new){
            var str = $(this).val();
            var str2 = SetTranslitRuToLat(str);
            $("#alias").val(str2);
        }
    });
    $("#item-form").submit(function(){
        var alias_page = $(this).find("input[name='alias']").val();
        if (alias_page != ''){
            var pattern = /^[a-z0-9_-]+$/i;
            if (!pattern.test(alias_page)){
                alert('Алиас содержит недопустимые символы');
                return false;
            }
        }


        var chs = $(this).find("input[name='parents[]']:checked");
        if (chs.length==0){
            alert("Необходимо выбрать хотя бы одну категорию");
            return false;
        }
    });
    $(".confirm").click(function(e){
        if (!confirm("Вы уверенны что хотите это сделать?")){
            e.preventDefault();
        }
    });
</script>
