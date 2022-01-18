<article class="panel panel-dark">
    <div class="panel-heading">
        <h2 class="panel-title"><span class="glyphicon glyphicon-user"></span> Комментарии
        </h2>
    </div>
    <div class="panel-body">
        {if $comments}

            {if $pagination}
                <div class="col-sm-7 pagin-no-margin">
                    {$pagination}
                </div>
            {/if}
            <div class="{if $pagination}col-sm-5{else}col-sm-12{/if} text-right">
                <p style="margin-top: 10px;">Показано материалов: {$start}-{$items_count+$start-1} из {$total}</p>
            </div>
            <div class="clearfix"></div>

            {section name=i loop=$comments}
                <article class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title"><span class="glyphicon glyphicon-user"></span> {$comments[i].user_name}
                            <div class="pull-right">IP: {$comments[i].ip}</div>
                        </h2>
                    </div>
                    <div class="panel-body">
                        {$comments[i].user_comment}
                        <p>&nbsp;</p>
                        <ul class="list-inline">
                            {if $comments[i].status == 0}
                            <li><a class="text-danger" href="?c=comments&id={$comments[i].id}&status=1"><span class="glyphicon glyphicon-off"></span> Включить</a></li>
                            {else}
                            <li><a href="?c=comments&id={$comments[i].id}&status=0"><span class="glyphicon glyphicon-off"></span> Отключить</a></li>
                            {/if}
                            <li><a href="?c=comments&id={$comments[i].id}"><span class="glyphicon glyphicon-pencil"></span> Изменить</a></li>
                            <li><a class="confirm" href="?c=comments&id={$comments[i].id}&action=remove""><span class="glyphicon glyphicon-remove"></span> Удалить</a></li>
                        </ul>
                        <a target="_blank" href="{$site_url}{$comments[i].module}/{$comments[i].material_id}">{$site_url}{$comments[i].module}/{$comments[i].material_id}</a>
                    </div>
                    <div class="panel-footer clearfix">
                        <div class="pull-left"><span class="glyphicon glyphicon-calendar"></span> {$comments[i].date_publ}</div>
                        <div class="pull-right">Модуль: {$comments[i].module_name}</div>
                    </div>
                </article>
            {/section}
            {if $pagination}
                <div class="col-sm-7 pagin-no-margin">
                    {$pagination}
                </div>
            {/if}
            <div class="{if $pagination}col-sm-5{else}col-sm-12{/if} text-right">
                <p style="margin-top: 10px;">Показано материалов: {$start}-{$items_count+$start-1} из {$total}</p>
            </div>
            <div class="clearfix"></div>
        {else}
            <p>Комментариев нет</p>
        {/if}
    </div>
</article>
