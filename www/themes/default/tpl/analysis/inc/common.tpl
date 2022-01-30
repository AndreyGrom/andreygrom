<h3>Общие данные</h3>
{if property_exists($item, 'host')}
    <p>
        {if property_exists($item, 'favicon')}
            <img style="width: 50px;" src="{$item->favicon}" alt="">
        {/if}
        Сайт: <strong>{$item->proto}{$item->host}</strong>
    </p>
{/if}

{if property_exists($item, 'ssl') && $item->ssl == 1}
    <div class="alert alert-success">Отлично! Защищено сертификатом SSL (протокл https://)</div>
{else}
    <div class="alert alert-warning">Предупреждение! Не защищено сертификатом SSL (протокл http://)</div>
{/if}
<p>Кодировка исходного кода (не тег meta[charset]): <strong>{$item->encoding}</strong></p>
{if property_exists($item, 'charset') && $item->charset !== ''}
    <p>Значение тега meta[charset]: <strong>{$item->charset}</strong></p>
    {if $item->encoding|lower == $item->charset|lower}
        <div class="alert alert-success">Отлично! Значение meta[charset] и реальная кодировка исходного кода
            HTML совпадает
        </div>
    {else}
        <div class="alert alert-danger">Ошибка! значение meta[charset] и реальная кодировка исходного кода
            HTML не совпадает
        </div>
    {/if}
{else}
    <div class="alert alert-danger">Ошибка! Тег meta[charset] не задан</div>
{/if}