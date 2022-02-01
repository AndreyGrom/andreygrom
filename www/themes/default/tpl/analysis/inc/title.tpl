<p><strong>Title страницы:</strong></p>
{if property_exists($item, 'title')}
    <p>{$item->title[0]->content}</p>
    {if count($item->title) > 1}
        <div class="alert alert-danger">
            Ошибка! На странице должен быть только один тег title. Сейчас их {count($item->title)}
        </div>
    {/if}
    {if $item->title[0]->length >= 10 && $item->title[0]->length <= 70}
        <div class="alert alert-success">
            Отлично! Длина тега title от 10 до 70 символов
        </div>
    {else}
        <div class="alert alert-warning">
            Предупреждение! Длина title должна быть от 10 до 70 символов. Сейчас длина
            - {$item->title[0]->length}
        </div>
    {/if}
{else}
    <div class="alert alert-danger">
        Ошибка! Title не задан
    </div>
{/if}