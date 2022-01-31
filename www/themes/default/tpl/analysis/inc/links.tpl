{if property_exists($item, 'links')}
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th>Ссылка</th>
                <th>Текст</th>
                <th>Внутренняя/Внешняя</th>
                <th>Индексация</th>
            </tr>
            {section name=i loop=$item->links}
                <tr>
                    <td style="max-width: 400px;">{$item->links[i].href}</td>
                    <td>{$item->links[i].text}</td>
                    <td>{$item->links[i].type}</td>
                    <td>{if $item->links[i].nofollow}nofollow{else}dofollow{/if}</td>
                </tr>
            {/section}
        </table>
    </div>
{else}
    <div class="alert alert-warning">Ссылок на данной странице нет</div>
{/if}