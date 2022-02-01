<p><strong>Meta-keywords страницы:</strong></p>
{if property_exists($item, 'meta_keywords') && $item->meta_keywords[0]->length > 0}
    <p>{$item->meta_keywords[0]->content}</p>
    {if count($item->meta_keywords) > 1}
        <div class="alert alert-danger">
            Ошибка: на странице должен быть только один тег meta-keywords. Сейчас их {count($item->meta_keywords)}
        </div>
    {/if}
    {if $item->meta_keywords[0]->length <= 250}
        <div class="alert alert-success">
            Отлично! Длина тега meta-keywords меньше 250 символов
        </div>
    {else}
        <div class="alert alert-warning">
            Предупреждение! Длина meta-keywords должна быть меньше 250 символов. Сейчас длина
            - {$item->meta_keywords[0]->length}
        </div>
    {/if}
{else}
    <div class="alert alert-danger">
        Ошибка! Тег meta-keywords не задан
    </div>
{/if}