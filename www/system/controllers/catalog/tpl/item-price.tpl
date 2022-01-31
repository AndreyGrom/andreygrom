<div class="form-horizontal" role="form">
    <div class="form-group">
        <label class="col-sm-3 control-label">Цена:</label>
        <div class="col-sm-9">
            <input value="{if isset($item)}{$item.price}{/if}" name="price" type="text" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Новая цена:</label>
        <div class="col-sm-9">
            <input value="{if isset($item)}{$item.price_new}{/if}" name="price_new" type="text" class="form-control">
        </div>
    </div>
</div>