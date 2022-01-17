<div class="form-group">
    <label class="col-sm-3 control-label">Статус:</label>
    <div class="col-sm-9">
        {assign var=Enabled value=$module_config.alias|cat:'Enabled'}
        <select name="{$Enabled}" class="form-control">
            <option {if $config->$Enabled == '1'}selected{/if} value="1">Модуль включен</option>
            <option {if $config->$Enabled == '0'}selected{/if} value="0">Модуль отключен</option>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Кол-во категорий на страницу:</label>
    <div class="col-sm-9">
        {assign var=CategoryListPerPage value=$module_config.alias|cat:'CategoryListPerPage'}
        <input required value="{$config->$CategoryListPerPage}" name="{$CategoryListPerPage}" type="text" class="form-control">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Кол-во материалов на страницу:</label>
    <div class="col-sm-9">
        {assign var=ItemListPerPage value=$module_config.alias|cat:'ItemListPerPage'}
        <input required value="{$config->$ItemListPerPage}" name="{$ItemListPerPage}" type="text" class="form-control">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Выводить последние материалы:</label>
    <div class="col-sm-9">
        {assign var=ItemListSort value=$module_config.alias|cat:'ItemListSort'}
        <select name="{$ItemListSort}" class="form-control">
            <option {if $config->$ItemListSort == 'DESC'}selected{/if} value="DESC">Вначале</option>
            <option {if $config->$ItemListSort == 'ASC'}selected{/if} value="ASC">В конце</option>
        </select>
    </div>
</div>
