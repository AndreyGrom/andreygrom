<div class="form-group">
    <label class="col-sm-3 control-label">Статус:</label>
    <div class="col-sm-9">
        {assign var=CommentsEnabled value=$module_config.alias|cat:'CommentsEnabled'}
        <select name="{$CommentsEnabled}" class="form-control">
            <option {if $config->$CommentsEnabled == '1'}selected{/if} value="1">Включены</option>
            <option {if $config->$CommentsEnabled == '0'}selected{/if} value="0">Отключены</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Премодерация комментариев:</label>
    <div class="col-sm-9">
        {assign var=CommentsModerationEnabled value=$module_config.alias|cat:'CommentsModerationEnabled'}
        <select name="{$CommentsModerationEnabled}" class="form-control">
            <option {if $config->$CommentsModerationEnabled == '1'}selected{/if} value="1">Включена</option>
            <option {if $config->$CommentsModerationEnabled == '0'}selected{/if} value="0">Выключена</option>
        </select>
    </div>
</div>
{*<div class="form-group">
    <label class="col-sm-3 control-label">Капча в комментариях:</label>
    <div class="col-sm-9">
        {assign var=CommentsCaptchaEnabled value=$module_config.alias|cat:'CommentsCaptchaEnabled'}
        <select name="{$CommentsCaptchaEnabled}" class="form-control">
            <option {if $config->$CommentsCaptchaEnabled == '1'}selected{/if} value="1">Включена</option>
            <option {if $config->$CommentsCaptchaEnabled == '0'}selected{/if} value="0">Выключена</option>
        </select>
    </div>
</div>*}
<div class="form-group">
    <label class="col-sm-3 control-label">Шаблон комментариев:</label>
    <div class="col-sm-9">
        {assign var=CommentsTemplateView value=$module_config.alias|cat:'CommentsTemplateView'}
        <select name="{$CommentsTemplateView}" class="form-control">
            {section name=i loop=$templates_comment_view}
                <option {if $templates_comment_view[i]==$config->$CommentsTemplateView}selected="selected" {/if} value="{$templates_comment_view[i]}">{$templates_comment_view[i]}</option>
            {/section}
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Шаблон формы комментариев:</label>
    <div class="col-sm-9">
        {assign var=CommentsTemplateForm value=$module_config.alias|cat:'CommentsTemplateForm'}
        <select name="{$CommentsTemplateForm}" class="form-control">
            {section name=i loop=$templates_comment_form}
                <option {if $templates_comment_form[i]==$config->$CommentsTemplateForm}selected="selected" {/if} value="{$templates_comment_form[i]}">{$templates_comment_form[i]}</option>
            {/section}
        </select>
    </div>
</div>