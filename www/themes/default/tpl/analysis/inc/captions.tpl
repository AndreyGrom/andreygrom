<h3>Заголовки</h3>
{if property_exists($item, 'caption_tags')}
    {if isset($item->caption_tags->tags->h1)}
        <div class="alert alert-success">Отлично! Тег H1: {$item->caption_tags->tags->h1[0]}</div>
        {if count($item->caption_tags->tags->h1) > 1}
            <div class="alert alert-danger">
                Ошибка! Тег H1 должнен встречаться один раз на странице. Сейчас их {count($item->caption_tags->tags->h1)}
            </div>
        {/if}
    {else}
        <div class="alert alert-warning">Предупреждение! Тег H1 не найден!</div>
    {/if}
    {if isset($item->caption_tags->tags->h1)}
        H1
        <ul>
            {section name=i loop=$item->caption_tags->tags->h1}
                <li>{$item->caption_tags->tags->h1[i]}</li>
            {/section}
        </ul>
    {/if}
    {if isset($item->caption_tags->tags->h2)}
        H2
        <ul>
            {section name=i loop=$item->caption_tags->tags->h2}
                <li>{$item->caption_tags->tags->h2[i]}</li>
            {/section}
        </ul>
    {/if}
    {if isset($item->caption_tags->tags->h3)}
        H3
        <ul>
            {section name=i loop=$item->caption_tags->tags->h3}
                <li>{$item->caption_tags->tags->h3[i]}</li>
            {/section}
        </ul>
    {/if}
    {if isset($item->caption_tags->tags->h4)}
        H4
        <ul>
            {section name=i loop=$item->caption_tags->tags->h4}
                <li>{$item->caption_tags->tags->h4[i]}</li>
            {/section}
        </ul>
    {/if}
    {if isset($item->caption_tags->tags->h5)}
        H5
        <ul>
            {section name=i loop=$item->caption_tags->tags->h5}
                <li>{$item->caption_tags->tags->h5[i]}</li>
            {/section}
        </ul>
    {/if}
    {if isset($item->caption_tags->tags->h6)}
        H6
        <ul>
            {section name=i loop=$item->caption_tags->tags->h6}
                <li>{$item->caption_tags->tags->h6[i]}</li>
            {/section}
        </ul>
    {/if}
{else}
    <div class="alert alert-warning">Предупреждение! Заголовки не найдены!</div>
{/if}