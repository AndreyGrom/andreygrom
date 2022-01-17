<div class="panel panel-dark">
    <div class="panel-heading">
        <h3 class="panel-title text-uppercase">
            <span class="glyphicon glyphicon-list"></span>
            {if $category}{$category.title} - {/if}список материалов
        </h3>
    </div>
    <div class="panel-body">
        {if $items}
            {if $num_pages > 1}
                <div class="col-sm-6">
                    {$pagination}
                </div>
            {/if}
            <div class="{if $num_pages > 1}col-sm-6{else}col-sm-12{/if} text-right">
                <p style="margin-top: 10px;">Показано материалов: {$start}-{$items_count + $start} из {$total}</p>
            </div>

            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Статус</th>
                    <th style="width: 144px;">Действия</th>
                </tr>
                {section name=i loop=$items}
                    <tr>
                        <td>{$items[i].id}</td>
                        <td><a href="?c={$module_config.alias}&category_id={$category.id}&material_id={$items[i].id}">{$items[i].title}</a></td>
                        <td>
                            {if $items[i].public==1}
                                <span class="glyphicon glyphicon-ok text-success"></span>
                            {else}
                                <span class="glyphicon glyphicon-minus text-danger"></span>
                            {/if}
                        </td>
                        <td>
                            <a target="_blank" class="btn btn-primary btn-mini" data-original-title="Перейти к материалу" title="" data-toggle="tooltip" href="/{$module_config.alias}/{$items[i].alias}">
                                <span class="glyphicon glyphicon-share-alt"></span>
                            </a>
                            <a class="btn btn-success btn-mini" data-original-title="Редактировать материал" title="" data-toggle="tooltip" href="?c={$module_config.alias}&category_id={$category.id}&material_id={$items[i].id}">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <a class="btn btn-danger btn-mini confirm" data-original-title="Материал будет полностью удален" title="" data-toggle="tooltip" href="?c={$module_config.alias}&action=remove-item&category_id={$category.id}&material_id={$items[i].id}">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </td>
                    </tr>
                {/section}
            </table>
        {else}
            Материалов в данной категории нет
        {/if}
    </div>
</div>

