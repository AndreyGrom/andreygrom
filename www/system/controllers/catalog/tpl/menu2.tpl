<ul {if !$sub}class="nav"{else}class="ul-sub"{/if}>

{section name=i loop=$categories}
    <li>
        <a href="?c={$module_config.alias}&category_id={$categories[i].id}" data-toggle="tooltip" title="{$categories[i].content|strip_tags|truncate:300}">{if !$sub}<span class="glyphicon glyphicon-book btn-xs"></span>{/if}{$categories[i].title}</a>
        {if $categories[i].sub}
            {include file="menu2.tpl" categories=$categories[i].sub sub=true}
        {/if}
    </li>
{/section}
</ul>