<div class="form-group">
    <label for="title" class="col-sm-3 control-label">Название:</label>
    <div class="col-sm-9">
        <input required value="{$page.title}" id="title" name="title" type="text" class="form-control" placeholder="Введите название страницы">
    </div>
</div>
<div class="form-group">
    <label for="alias" class="col-sm-3 control-label">Алиас:</label>
    <div class="col-sm-9">
        <input value="{$page.alias}" id="alias" name="alias" type="text" class="form-control" placeholder="Только символы a-z, A-Z, 0-9, -_ " />
        <p class="help-block">Только символы a-z, A-Z, 0-9, -_ <br/>
            Можно оставить пустым. Заполнится автоматически</p>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Уровень:</label>
    <div class="col-sm-9">
        <select {if $page.id==1}disabled{/if} name="parent_id" class="form-control">
            <option value="0">Верхний уровень</option>
            {section name=i loop=$pages}
                {if $pages[i].id !== $page.id}
                    <option {if $pages[i].id == $page.parent_id}selected="selected"{/if} value="{$pages[i].id}">{$pages[i].title}</option>
                {/if}
            {/section}
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Шаблон:</label>
    <div class="col-sm-9">
        <select name="template" class="form-control">
            {section name=i loop=$templates}
                <option {if $templates[i]==$page.template}selected="selected" {/if} value="{$templates[i]}">{$templates[i]}</option>
            {/section}
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Публикация:</label>
    <div class="col-sm-9">
        <select name="publ" class="form-control">
            <option {if $page.publ == '1'}selected{/if} value="1">Опубликовано</option>
            <option {if $page.publ == '0'}selected{/if} value="0">Черновик</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Комментарии:</label>
    <div class="col-sm-9">
        <select name="comments" class="form-control">
            <option {if $page.comments == '1'}selected{/if} value="1">Включены</option>
            <option {if $page.comments == '0'}selected{/if} value="0">Отключены</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="alias" class="col-sm-3 control-label">Позиция:</label>
    <div class="col-sm-9">
        <input value="{$page.position}" name="position" type="text" class="form-control" />
    </div>
</div>
<div class="form-group">
    <label for="alias" class="col-sm-3 control-label">Просмотры:</label>
    <div class="col-sm-9">
        <input value="{$page.views}" name="views" type="text" class="form-control" />
    </div>
</div>