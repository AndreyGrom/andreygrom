<ul {if !$sub}class="nav"{else}class="ul-sub"{/if}>
{section name=i loop=$pages}
    <li>
        <a href="?c={$module_alias}&id={$pages[i].ID}" data-toggle="tooltip" title="{$pages[i].CONTENT|strip_tags|truncate:300}">{if !$sub}<span class="glyphicon glyphicon-text-size btn-xs"></span>{/if}{$pages[i].TITLE}</a>
        {if $pages[i].SUB}
            {include file="menu2.tpl" pages=$pages[i].SUB sub=true}
        {/if}
    </li>
{/section}
</ul>