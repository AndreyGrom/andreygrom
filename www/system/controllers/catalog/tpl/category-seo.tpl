<div class="form-group">
    <label for="" class="col-sm-3 control-label">Meta-title:</label>
    <div class="col-sm-9">
        <input value="{if isset($item)}{$item.meta_title}{/if}" name="meta_title" type="text" class="form-control" />
    </div>
</div>
<div class="form-group">
    <label for="" class="col-sm-3 control-label">Meta-description:</label>
    <div class="col-sm-9">
        <input value="{if isset($item)}{$item.meta_desc}{/if}" name="meta_desc" type="text" class="form-control" />
    </div>
</div>
<div class="form-group">
    <label for="" class="col-sm-3 control-label">Meta-keywords:</label>
    <div class="col-sm-9">
        <input value="{if isset($item)}{$item.meta_keywords}{/if}" name="meta_keywords" type="text" class="form-control" />
    </div>
</div>