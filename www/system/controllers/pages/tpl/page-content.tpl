<div class="form-group">
    <label for="content" class="col-sm-12">Краткое описание:</label>
    <div class="col-sm-12">
        <textarea class="textarea-edit" name="short_content" style="width:100%;height:200px;">{if isset($page)}{$page.short_content}{/if}</textarea>
    </div>
</div>
<div class="form-group">
    <label for="content" class="col-sm-12">Содержимое:</label>
    <div class="col-sm-12">
        <textarea class="textarea-edit" name="content" style="width:100%;height:400px;">{if isset($page)}{$page.content}{/if}</textarea>
    </div>
</div>
