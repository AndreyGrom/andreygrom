<div class="form-horizontal" role="form">

    <div class="form-group">
        <label for="title" class="col-sm-3 control-label">Название:</label>
        <div class="col-sm-9">
            <input required value="{$item.title}" name="title" id="title" type="text" class="form-control" placeholder="Введите название материала">
        </div>
    </div>
    <div class="form-group">
        <label for="alias" class="col-sm-3 control-label">Алиас:</label>
        <div class="col-sm-9">
            <input value="{$item.alias}" name="alias" id="alias" type="text" class="form-control" placeholder="Только символы a-z, A-Z, 0-9, -_ " />
            <p class="help-block">
                <a href="#" class="btn btn-dark btn-sm pull-right" id="check_alias">Проверить</a>
                Только символы a-z, A-Z, 0-9, -_ <br/>
                Можно оставить пустым. Заполнится автоматически
            </p>
        </div>
    </div>
    <div class="form-group">
        <label for="parent" class="col-sm-3 control-label">Категории:</label>
        <div class="col-sm-9">
            <div style="height: 100px;overflow:auto;border:1px solid #ccc;padding: 3px;">
                {include file="item-categories.tpl"}
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="template" class="col-sm-3 control-label">Шаблон:</label>
        <div class="col-sm-9">
            <select name="template" id="template" class="form-control">
                {section name=i loop=$templates}
                    <option {if $templates[i]==$item_template}selected="selected" {/if} value="{$templates[i]}">{$templates[i]}</option>
                {/section}
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Публикация:</label>
        <div class="col-sm-9">
            <select name="public" class="form-control">
                <option {if $item.public == '1'}selected{/if} value="1">Опубликовано</option>
                <option {if $item.public == '0'}selected{/if} value="0">Черновик</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Комментарии:</label>
        <div class="col-sm-9">
            <select name="comments" class="form-control">
                <option {if $item.comments == '1'}selected{/if} value="1">Включены</option>
                <option {if $item.comments == '0'}selected{/if} value="0">Отключены</option>
            </select>
        </div>
    </div>
</div>