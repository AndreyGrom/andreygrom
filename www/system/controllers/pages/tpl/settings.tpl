<form method="post">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase">
                <span class="glyphicon glyphicon-duplicate"></span>
                Настройки модуля "Страницы сайта"
            </h3>
        </div>
        <div class="panel-body">
            <div class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Статус:</label>
                    <div class="col-sm-9">
                        <select name="PagesEnabled" id="PagesEnabled" class="form-control">
                            <option {if $config->PagesEnabled == '1'}selected{/if} value="1">Модуль включен</option>
                            <option {if $config->PagesEnabled == '0'}selected{/if} value="0">Модуль отключен</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Название модуля:</label>
                    <div class="col-sm-9">
                        <input required value="{$config->PagesModuleTitle}" name="PagesModuleTitle" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Комментарии:</label>
                    <div class="col-sm-9">
                        <select name="PagesCommentsEnabled" id="PagesCommentsEnabled" class="form-control">
                            <option {if $config->PagesCommentsEnabled == '1'}selected{/if} value="1">Включены</option>
                            <option {if $config->PagesCommentsEnabled == '0'}selected{/if} value="0">Отключены</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="GalleryCommentsTemplateView" class="col-sm-3 control-label">Шаблон комментариев:</label>
                    <div class="col-sm-9">
                        <select name="PagesCommentsTemplateView" id="PagesCommentsTemplateView" class="form-control">
                            {section name=i loop=$templates_comment_view}
                                <option {if $templates_comment_view[i]==$config->PagesCommentsTemplateView}selected="selected" {/if} value="{$templates_comment_view[i]}">{$templates_comment_view[i]}</option>
                            {/section}
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="GalleryCommentsTemplateForm" class="col-sm-3 control-label">Шаблон формы комментариев:</label>
                    <div class="col-sm-9">
                        <select name="PagesCommentsTemplateForm" id="PagesCommentsTemplateForm" class="form-control">
                            {section name=i loop=$templates_comment_form}
                                <option {if $templates_comment_form[i]==$config->PagesCommentsTemplateForm}selected="selected" {/if} value="{$templates_comment_form[i]}">{$templates_comment_form[i]}</option>
                            {/section}
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" name="save-settings" class="btn btn-success btn-large"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
            </div>
        </div>
    </div>
</form>