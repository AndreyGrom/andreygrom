<form id="page-form" action="" method="post">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase">
                <span class="glyphicon glyphicon-duplicate"></span>
                {if !$page}Создание новой страницы{else}Редактирование страницы{/if}

            </h3>
        </div>
        <div class="panel-body">
            {if $page}

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
                    <button type="button" id="save-page" class="btn btn-dark"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="save-page" value="1">
</form>

<script>
    $("#save-page").click(function (e) {
        var alias_field = $("#alias");
        var title = $("#title").val();
        if (alias_field.val() === ''){
            alias_field.val(SetTranslitRuToLat(title));
        }
        var data = "action=CheckAlias&alias=" + alias_field.val();
        {if $page}data += "&id={$page.id}";{/if}
        $.ajax({
            type: "POST",
            data: data,
            success: function(msg){
                if (msg == 0){
                    $("#page-form").submit();
                } else {
                    alert(msg);
                }
            }
        });
    });
    $("#page-form2").submit(function(){
        var form = $(this);
        var alias_field = $("#alias");
        var title = $("#title").val();
        if (alias_field.val() === ''){
            alias_field.val(SetTranslitRuToLat(title));
        }


    });
/*    var alias_page_new = false;
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
    $("#page-form").submit(function(){
        var alias_page = $(this).find("input[name='alias']").val();
        if (alias_page != ''){
        var pattern = /^[a-z0-9_-]+$/i;
            if (!pattern.test(alias_page)){
                alert('Алиас содержит недопустимые символы');
                return false;
            }
        }
    });
    $(".confirm").click(function(e){
        if (!confirm("Вы уверенны что хотите удалить страницу?")){
            e.preventDefault();
        }
    });*/
</script>