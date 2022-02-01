<p><strong>Метатеги Open Graph:</strong></p>
{if property_exists($item, 'meta_og')}
    <div class="alert alert-success">Отлично! Найдены метатеги Open Graph</div>
    <ul>
        {section name=i loop=$item->meta_og}
            <li>{$item->meta_og[i]->property} : {$item->meta_og[i]->content}</li>
        {/section}
    </ul>
{else}
    <div class="alert alert-warning">
        Предупреждение! Метатеги Open Graph не найдены!
    </div>
{/if}