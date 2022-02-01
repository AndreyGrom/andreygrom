{include file="../../common/header.tpl" class = "main-catalog"}

<aside>
    <div class="container">
        <h1 class="page-title">Анализ сайтов/страниц</h1>
        <div class="row">
            <div class="col-sm-9">
                    {if isset($items)}
                        <table class="table table-hover">
                            <tr>
                                <th>URL</th>
                                <th>Дата обновления</th>
                            </tr>
                            {section name=i loop=$items}
                                <tr>
                                    <td><a href="/analysis/{$items[i].id}">{$items[i].url}</a></td>
                                    <td>{$items[i].last_update}</td>
                                </tr>
                            {/section}
                        </table>
                    {else}
                        <div class="alert alert-danger">
                            <p>В данной категории ничего нет</p>
                        </div>
                    {/if}
            </div>
            <div class="col-sm-3">
                {include file="../../common/sidebar-right.tpl"}
            </div>
        </div>
    </div>
</aside>

{include file="../../common/footer.tpl"}