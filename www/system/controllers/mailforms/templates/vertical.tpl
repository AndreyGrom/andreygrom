<form class="agcms-mailform" method="post" action="#" autocomplete="off">
    <input type="hidden" name="form_id" value="{$form.id}">
    {section name=i loop=$form.fields}
        <div class="form-group">
            <label for="email">{$form.fields[i].name}</label>
            {if $form.fields[i].type == 'textarea'}
                <textarea {if $form.fields[i].required}required{/if} name="field_{$form.fields[i].id}" id="field_{$form.fields[i].id}" placeholder="{$form.fields[i].placeholder}" class="form-control"></textarea>
            {elseif $form.fields[i].type == 'checkbox'}
                <input type="checkbox" name="field_{$form.fields[i].id}" id="field_{$form.fields[i].id}">
             {elseif $form.fields[i].type == 'select'}
                <select name="field_{$form.fields[i].id}" id="field_{$form.fields[i].id}" class="form-control">
                    {section name=j loop=$form.fields[i].values}
                        <option value="{$form.fields[i].values[j]}">{$form.fields[i].values[j]}</option>
                    {/section}
                </select>
             {else}
                <input {if $form.fields[i].required}required{/if} name="field_{$form.fields[i].id}" id="field_{$form.fields[i].id}" type="{$form.fields[i].type}" class="form-control" placeholder="{$form.fields[i].placeholder}">
            {/if}

        </div>
    {/section}
    <button type="submit" class="btn btn-outline-warning btn-outline-warning-o pull-right">Отправить</button>
</form>