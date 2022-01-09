
<div class="panel panel-dark">
    <div class="panel-heading">
        <h3 class="panel-title text-uppercase">
            <span class="glyphicon glyphicon-duplicate"></span>
            {if !$item}
                Создание новой категории
            {else}
                Редактирование категории
                <a href="?c={$module_config.alias}&category_id={$item.id}&action=remove-category" class="btn btn-danger btn-xs pull-right remove-confirm">
                    <i class="glyphicon glyphicon-remove" aria-hidden="true"></i> Удалить категорию
                </a>
            {/if}
        </h3>
    </div>

    <div class="panel-body">
        {if $item}
            <table class="table table-bordered table-hover">
                <tr>
                    <td>URL: <br><a target="_blank" href="{$site_url}{$item.alias}">{$site_url}{$item.alias}</a></td>
                    <td>Дата создания: <br>{$item.date_create|date_format:"%D %T"}</td>
                    <td>Дата изменения: <br>{$item.date_edit|date_format:"%D %T"}</td>
                </tr>
            </table>
            <hr/>
        {/if}
        <form method="post" class="form-horizontal" role="form">
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
                <button type="submit" name="save-category" class="btn btn-dark"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
            </div>
        </form>
    </div>
</div>

