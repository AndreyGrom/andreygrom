<ul {if !isset($sub)}class="nav" {else}class="ul-sub"{/if}>

{section name=i loop=$pages}
    <li>
        <a href="?c={$module_config.alias}&id={$pages[i].id}" data-toggle="tooltip" title="{$pages[i].content|strip_tags|truncate:300}">
            {if !isset($sub)}<span class="glyphicon glyphicon-text-size btn-xs"></span>{/if}
            {$pages[i].title}
        </a>
        {if isset($pages[i].sub)}
            {include file="menu2.tpl" pages=$pages[i].sub sub=true}
        {/if}
    </li>
{/section}
</ul>