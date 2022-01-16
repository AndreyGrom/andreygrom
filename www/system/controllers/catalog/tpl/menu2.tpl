<ul {if !$sub}class="nav"{else}class="ul-sub"{/if}>

{section name=i loop=$categories}
    <li>
        <a class="pull-left" href="?c={$module_config.alias}&category_id={$categories[i].id}" data-toggle="tooltip" title="{$categories[i].content|strip_tags|truncate:300}">
            {if !$sub}
                <span class="glyphicon glyphicon-book btn-xs"></span>
            {/if}{$categories[i].title}</a>
        <a class="pull-right" data-toggle="tooltip" data-original-title="Редактировать категорию" href="?c={$module_config.alias}&category_id={$categories[i].id}&action=category-edit"><span class="glyphicon glyphicon-pencil btn-xs"></span></a>
        <div class="clearfix"></div>
        {if $categories[i].sub}
            {include file="menu2.tpl" categories=$categories[i].sub sub=true}
        {/if}
    </li>
{/section}
</ul>