<p><strong>Meta-description страницы:</strong></p>
{if property_exists($item, 'meta_description') && $item->meta_description[0]->length > 0}
    <p>{$item->meta_description[0]->content}</p>
    {if count($item->meta_description) > 1}
        <div class="alert alert-danger">
            Ошибка: на странице должен быть только один тег meta-description. Сейчас их {count($item->meta_description)}
        </div>
    {/if}
    {if $item->meta_description[0]->length >= 70 && $item->meta_description[0]->length <= 160}
        <div class="alert alert-success">
            Отлично! Длина тега meta-description от 70 до 160 символов
        </div>
    {else}
        <div class="alert alert-warning">
            Предупреждение! Длина meta-description должна быть от 70 до 160 символов. Сейчас длина
            - {$item->meta_description[0]->length}
        </div>
    {/if}
{else}
    <div class="alert alert-danger">
        Ошибка! Тег meta-description не задан
    </div>
{/if}