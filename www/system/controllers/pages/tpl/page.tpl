<form id="page-form" action="" method="post">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase">
                <span class="glyphicon glyphicon-duplicate"></span>
                {if !$page}Создание новой страницы{else}Редактирование страницы{/if}
                {if $page}
                    <span class="pull-right text-lowercase">
                        <button class="btn btn-success btn-xs" type="submit">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                            Сохранить
                        </button>
                    </span>
                {/if}
            </h3>
        </div>
        <div class="panel-body">
            {if $page}
                <span class="col-sm-3 text-right">URL страницы</span>
                <span class="col-sm-9"><a target="_blank" href="{$site_url}{$page.ALIAS}">{$site_url}{$page.ALIAS}</a></span>
                <hr/>
            {/if}
            <div class="form-horizontal" role="form">

                <div class="form-group">
                    <label for="title" class="col-sm-3 control-label">Название:</label>
                    <div class="col-sm-9">
                        <input required value="{$page.TITLE}" name="title" id="title" type="text" class="form-control" placeholder="Введите название страницы">
                    </div>
                </div>
                <div class="form-group">
                    <label for="alias" class="col-sm-3 control-label">Алиас:</label>
                    <div class="col-sm-9">
                        <input value="{$page.ALIAS}" name="alias" id="alias" type="text" class="form-control" placeholder="Только символы a-z, A-Z, 0-9, -_ " />
                        <p class="help-block">Только символы a-z, A-Z, 0-9, -_ <br/>
                            Можно оставить пустым. Заполнится автоматически</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="parent" class="col-sm-3 control-label">Уровень:</label>
                    <div class="col-sm-9">
                        <select {if $page.ID==1}disabled{/if} name="parent" id="parent" class="form-control">
                            <option value="0">Верхний уровень</option>
                            {section name=i loop=$pages}
                                {if $pages[i].ID !== $page_id}
                                <option {if $pages[i].ID==$page.PARENT}selected="selected"{/if} value="{$pages[i].ID}">{$pages[i].TITLE}</option>
                                {/if}
                            {/section}
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="template" class="col-sm-3 control-label">Шаблон:</label>
                    <div class="col-sm-9">
                        <select name="template" id="template" class="form-control">
                            {section name=i loop=$templates}
                                <option {if $templates[i]==$page.TEMPLATE}selected="selected" {/if} value="{$templates[i]}">{$templates[i]}</option>
                            {/section}
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="publ" class="col-sm-3 control-label">Публикация:</label>
                    <div class="col-sm-9">
                        <select name="publ" id="publ" class="form-control">
                            <option {if $page.PUBL == '1'}selected{/if} value="1">Опубликовано</option>
                            <option {if $page.PUBL == '0'}selected{/if} value="0">Черновик</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="content" class="col-sm-12">Содержимое:</label>
                    <div class="col-sm-12">

                        <textarea class="textarea-edit" name="content" id="content" style="width:100%;height:400px;">{$page.CONTENT}</textarea>

                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Meta-title:</label>
                    <div class="col-sm-9">
                        <input value="{$page.META_TITLE}" name="meta_title" type="text" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Meta-description:</label>
                    <div class="col-sm-9">
                        <input value="{$page.META_DESC}" name="meta_description" type="text" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Meta-keywords:</label>
                    <div class="col-sm-9">
                        <input value="{$page.META_KEYWORDS}" name="meta_keywords" type="text" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-success btn-large"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
            </div>

        </div>
    </div>
</form>

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
    });
</script>