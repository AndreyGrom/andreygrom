<div class="form-horizontal" role="form">
    <div class="form-group">
        <label for="content" class="col-sm-12">Краткое описание:</label>
        <div class="col-sm-12">
            <textarea name="short_content" class="form-control textarea-edit" id="short_content" style="width:100%;height:100px;">{$item.short_content}</textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="col-sm-12">Полное описание:</label>
        <div class="col-sm-12">
            <textarea class="form-control textarea-edit" name="content" id="content" style="width:100%;height:400px;">{$item.content}</textarea>
        </div>
    </div>
</div>