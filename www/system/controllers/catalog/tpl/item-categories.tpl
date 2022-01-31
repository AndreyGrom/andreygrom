<ul{if !isset($sub)} class="list-unstyled"{else} style="list-style: none;padding-left:10px;"{/if}>
    {section name=i loop=$categories}
        <li>
            <label>
                <input type="checkbox" name="parents[]"
                        {section name=j loop=$item.parents}
                            {if $item.parents[j].category_id == $categories[i].id} checked="checked" {/if}
                        {/section}
                       value="{$categories[i].id}"/> {$categories[i].title}
            </label>
            {if isset($categories[i].sub)}
                {include file="item-categories.tpl" categories=$categories[i].sub sub=true}
            {/if}
        </li>
    {/section}
</ul>