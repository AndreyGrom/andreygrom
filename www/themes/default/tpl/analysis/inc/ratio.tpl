{if property_exists($item, 'length_html')}
    <p>Длина исходного кода с пробелами: <strong>{$item->length_html}</strong></p>
    <p>Длина текста с пробелами(без html-тегов): <strong>{$item->length_plain}</strong></p>
    {if $item->ratio < 15}
        <div class="alert alert-danger">
            Ошибка! Соотношение HMTL/Текст: <strong>{$item->ratio}%</strong><br>
            Должно быть больше 15%
        </div>
    {else}
        <div class="alert alert-success">
            Отлично! Соотношение HMTL/Текст: <strong>{$item->ratio}%</strong><br>
            Должно быть больше 15%
        </div>
    {/if}
{/if}