
<p>&nbsp;</p>
{if property_exists($item, 'host')}
    <div class="clearfix">
        {if property_exists($item, 'favicon')}
            <img style="width: 50px;" src="{$item->favicon}" alt="">
        {/if}
        Сайт: <strong>{$item->proto}{$item->host}</strong>
        <div class="pull-right">
            Обновлено: {$last_update}
            <div class="text-right">
            {if $upd}
                <a href="/analysis/{$id}/update" class="btn btn-dark">Обновить</a>
            {else}
                Обновлять можно только раз в сутки
            {/if}
            </div>
        </div>
    </div>
    <p>&nbsp;</p>
{/if}

{if property_exists($item, 'ssl') && $item->ssl == 1}
    <div class="alert alert-success">Отлично! Защищено сертификатом SSL (протокл https://)</div>
{else}
    <div class="alert alert-warning">Предупреждение! Не защищено сертификатом SSL (протокл http://)</div>
{/if}
{if property_exists($item, 'encoding')}
<p>Кодировка исходного кода (не тег meta[charset]): <strong>{$item->encoding}</strong></p>
{/if}
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