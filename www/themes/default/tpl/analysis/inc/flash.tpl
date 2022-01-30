{if property_exists($item, 'flash')}
    <table class="table table-hover">
        <tr>
            <th>src</th>
            <th>alt</th
            <th>title</th>
        </tr>
        {section name=i loop=$item->flash}
            <tr>
                <td>{$item->flash[i].src}</td>
                <td>{$item->flash[i].alt}</td>
                <td>{$item->flash[i].title}</td>
            </tr>
        {/section}
    </table>
{else}
    <div class="alert alert-warning">Flash-контента на данной странице нет</div>
{/if}
{if property_exists($item, 'iframe')}
    <table class="table table-hover">
        <tr>
            <th>src</th>
        </tr>
        {section name=i loop=$item->iframe}
            <tr>
                <td>{$item->iframe[i].src}</td>
            </tr>
        {/section}
    </table>
{else}
    <div class="alert alert-warning">Ифреймов на данной странице нет</div>
{/if}