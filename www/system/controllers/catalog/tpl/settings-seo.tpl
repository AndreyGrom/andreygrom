<div class="form-group">
    <label class="col-sm-3 control-label">Meta-title модуля:</label>
    <div class="col-sm-9">
        {assign var=ModuleTitle value=$module_config.alias|cat:'ModuleTitle'}
        <input required value="{$config->$ModuleTitle}" name="{$ModuleTitle}" type="text" class="form-control">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Meta-description модуля:</label>
    <div class="col-sm-9">
        {assign var=ModuleDescription value=$module_config.alias|cat:'ModuleDescription'}
        <textarea name="{$ModuleDescription}" cols="2" rows="1" class="form-control">{$config->$ModuleDescription}</textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Meta-keywords модуля:</label>
    <div class="col-sm-9">
        {assign var=ModuleKeywords value=$module_config.alias|cat:'ModuleKeywords'}
        <textarea name="{$ModuleKeywords}" id="" cols="2" rows="1" class="form-control">{$config->$ModuleKeywords}</textarea>
    </div>
</div>