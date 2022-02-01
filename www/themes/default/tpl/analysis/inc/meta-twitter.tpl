<p><strong>Метатеги Twitter:</strong></p>
{if property_exists($item, 'meta_twitter')}
    <div class="alert alert-success">Отлично! Найдены метатеги Twitter</div>
    <ul>
        {section name=i loop=$item->meta_twitter}
            <li>{$item->meta_twitter[i]->name} : {$item->meta_twitter[i]->content}</li>
        {/section}
    </ul>
{else}
    <div class="alert alert-warning">
        Предупреждение! Метатеги Twitter не найдены!
    </div>
{/if}