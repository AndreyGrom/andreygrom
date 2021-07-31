<form id="page-form" action="" method="post">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase">
                <span class="glyphicon glyphicon-duplicate"></span>
                Редактор шаблонов модуля "Страницы сайта"
            </h3>
        </div>
        <div class="panel-body">
            <h5>Список шаблонов: <div class="pull-right"><a href="?c={$module_alias}&act=templates&add"><span class="glyphicon glyphicon-plus"></span> Создать новый шаблон</a></div></h5>
            <ul class="list-unstyled tempalte-edit-list">
                {section name=i loop=$templates}
                    <li {if $templates[i]==$smarty.get.template}class="active"{/if}><a href="?c={$module_alias}&act=templates&template={$templates[i]}">{$templates[i]}</a></li>
                {/section}
            </ul>
            <input type="hidden" name="template-name" value="{$template_name}"/>
            {if $template|| $new}

            <div class="form-horizontal" role="form">
                {if $new}
                <div class="form-group">
                    <label for="content" class="col-sm-12">Название шаблона (Только английские буквы и цифры. Пробелы не допускаются):</label>
                    <div class="col-sm-12">
                        <input required type="text" name="template-name" value="{$template_name}" class="form-control"/>
                    </div>
                </div>
                {else}
                    <input type="hidden" name="template-name" value="{$template_name}" class="form-control"/>
                {/if}
                <div class="form-group">
                    <label for="content" class="col-sm-12">Содержимое:
                        <div class="pull-right">
                            <a class="delete-template-link" href="?c={$module_alias}&act=templates&template={$smarty.get.template}&del"><span class="glyphicon glyphicon-trash"></span> Удалить шаблон</a>
                        </div>
                    </label>
                    <div class="col-sm-12">
                        <textarea name="template-content" id="template-content" style="width:100%;height:400px;">{$template}</textarea>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-success btn-large"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
            </div>
                <br/>
                <div class="alert alert-info">
                    <h4>Переменные модуля:</h4>
                    <div class="global-vars-list">
                        <div class="row">
                            <div class="col-sm-3">
                                <input readonly type="text" value="{literal}{$site_title}{/literal}" class="form-control"/>
                            </div>
                            <label class=col-sm-9""> - Title сайта</label>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <input readonly type="text" value="{literal}{$page_title}{/literal}" class="form-control"/>
                            </div>
                            <label class=col-sm-9""> - Заголовок страницы</label>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <input readonly type="text" value="{literal}{$page_content}{/literal}" class="form-control"/>
                            </div>
                            <label class=col-sm-9""> - Контент страницы</label>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info">
                    {include file="../../global-vars.tpl"}
                </div>
            {else}
                <div class="alert alert-danger">
                    <p>Выберите шаблон для редактирования из списка выше или создайте новый</p>
                </div>
            {/if}
        </div>
    </div>
</form>
<script>
    $(".delete-template-link").click(function(e){
        if (!confirm('Вы действительно хотите удалить шаблон?')){
            e.preventDefault();
        }
    });
</script>