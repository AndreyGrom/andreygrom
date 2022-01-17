<article class="panel panel-primary">
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
                    <h2 class="panel-title"><span class="glyphicon glyphicon-user"></span> {$comments[i].USER_NAME}
                        <div class="pull-right">IP: {$comments[i].IP}</div>
                    </h2>
                </div>
                <div class="panel-body">
                    {$comments[i].USER_COMMENT}
                    <ul class="list-inline">
                        {if $comments[i].STATUS == 0}
                        <li><a class="text-danger" href="?c=comments&id={$comments[i].ID}&status=1"><span class="glyphicon glyphicon-off"></span> Включить</a></li>
                        {else}
                        <li><a href="?c=comments&id={$comments[i].ID}&status=0"><span class="glyphicon glyphicon-off"></span> Отключить</a></li>
                        {/if}
                        <li><a href="?c=comments&id={$comments[i].ID}"><span class="glyphicon glyphicon-pencil"></span> Изменить</a></li>
                        <li><a class="del-comment" href="?c=comments&id={$comments[i].ID}&act=del""><span class="glyphicon glyphicon-remove"></span> Удалить</a></li>
                    </ul>
                    <a target="_blank" href="{$site_url}{$comments[i].CONTROLLER}/{$comments[i].MATERIAL_ID}">{$site_url}{$comments[i].CONTROLLER}/{$comments[i].MATERIAL_ID}</a>
                </div>
                <div class="panel-footer clearfix">
                    <div class="pull-left"><span class="glyphicon glyphicon-calendar"></span> {$comments[i].DATE_PUBL}</div>
                    <div class="pull-right">Модуль: {$comments[i].MODULE_NAME}</div>
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
    </div>
</article>
<script>
    $(".del-comment").click(function(e){
        if (!confirm('Вы действительно хотите удалить комментарий?')) {
            e.preventDefault();
        }
    });
</script>
{else}
    <p>Комментариев нет</p>
{/if}