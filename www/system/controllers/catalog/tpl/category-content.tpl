
<div class="form-group">
    <label for="content" class="col-sm-12">Краткое описание:</label>
    <div class="col-sm-12">
        <textarea class="textarea-edit form-control" id="desc1" name="desc1">{if isset($item)}{$item.desc1}{/if}</textarea>
    </div>
</div>
<div class="form-group">
    <label for="content" class="col-sm-12">Полное описание:</label>
    <div class="col-sm-12">
        <textarea class="textarea-edit" id="desc2" name="desc2" style="width:100%;height:200px;">{if isset($item)}{$item.desc2 }{/if}</textarea>
    </div>
</div>