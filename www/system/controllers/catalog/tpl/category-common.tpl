<div class="form-group">
    <label for="title" class="col-sm-3 control-label">Название:</label>
    <div class="col-sm-9">
        <input required value="{$item.title}" id="title" name="title" type="text" class="form-control">
    </div>
</div>
<div class="form-group">
    <label for="alias" class="col-sm-3 control-label">Алиас:</label>
    <div class="col-sm-9">
        <input value="{$item.alias}" id="alias" name="alias" type="text" class="form-control" placeholder="Только символы a-z, A-Z, 0-9, -_ " />
        <p class="help-block">
            <a href="#" class="pull-right" id="check_alias">Проверить</a>
            Только символы a-z, A-Z, 0-9, -_ <br/>
            Можно оставить пустым. Заполнится автоматически

        </p>
    </div>
</div>
<script>
    $("#check_alias").click(function (e) {
        e.preventDefault();
        var el = $(this);
        var data = 'check-alias-category=true&alias=' + $("#alias").val();
        {if $item.alias}data += '&id={$item.id}';{/if}
        el.html('Запрос....');
        $.ajax({
            type: "POST",
            data: data,
            success: function(msg){
                el.html(msg);
            }
        });
    });
</script>
<div class="form-group">
    <label for="template" class="col-sm-3 control-label">Изображение:</label>
    <div class="col-sm-4">
        <input name="image" id="image" type="file" class="" />
        <input type="hidden" name="old_image" value="{$item.image}"/>
        <p class="help-block">.jpg, .jpeg, .png, .gif</p>
    </div>
    <div class="col-sm-3">
        {if $item.image}
            <a class="fancybox" href="/upload/images/{$module_config.alias}/{$item.image}">
                <img style="width:200px;" src="/upload/images/{$module_config.alias}/{$item.image}" alt=""/>
            </a>
            <br/>
            <label><input name="delete_image" type="checkbox"/> Удалить</label>
        {/if}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Уровень:</label>
    <div class="col-sm-9">
        <select name="parent_id" class="form-control">
            <option value="0">Верхний уровень</option>
            {section name=i loop=$categories}
                {if $categories[i].id !== $item.id}
                    <option {if $categories[i].id == $item.parent_id}selected="selected"{/if} value="{$categories[i].id}">{$categories[i].title}</option>
                {/if}
            {/section}
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Шаблон:</label>
    <div class="col-sm-9">
        <select name="template" id="template" class="form-control">
            {section name=i loop=$templates}
                <option {if $templates[i]==$item.template}selected="selected" {/if} value="{$templates[i]}">{$templates[i]}</option>
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
<div class="form-group">
    <label for="alias" class="col-sm-3 control-label">Позиция:</label>
    <div class="col-sm-9">
        <input value="{$item.position}" name="position" type="text" class="form-control" />
    </div>
</div>