<div class="panel panel-dark">
    <div class="panel-heading">
        <h3 class="panel-title text-uppercase">
            <span class="glyphicon glyphicon-list"></span>
            Список сайтов
        </h3>
    </div>
    <div class="panel-body">
        <div class="text-right">
            <a class="btn btn-dark" href="#" data-toggle="modal" data-target="#add-sites-modal"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Добавить сайты</a>
        </div>
        <hr>
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
                    <th>URL</th>
                    <th>Загружено</th>
                    <th>Дата обновления</th>
                    <th style="width: 144px;">Действия</th>
                </tr>
                {section name=i loop=$items}
                    <tr>
                        <td>{$items[i].id}</td>
                        <td><a href="?c=analysis&id={$items[i].id}">{$items[i].url}</a></td>
                        <td>
                            {if $items[i].content}
                                <i class="fa fa-check-circle"></i>
                            {else}
                                <i class="fa fa-minus"></i>
                            {/if}
                        </td>
                        <td>
                            {$items[i].last_update}
                        </td>
                        <td>
                            <a class="btn btn-primary btn-xs" data-original-title="Загрузить/Обновить" title="" data-toggle="tooltip" href="?c={$module_config.alias}&action=download-site&id={$items[i].id}">
                                <span class="glyphicon glyphicon-download-alt"></span>
                            </a>
                            <a target="_blank" class="btn btn-primary btn-xs" data-original-title="Перейти к анализу" title="" data-toggle="tooltip" href="/{$module_config.alias}/{$items[i].id}">
                                <span class="glyphicon glyphicon-share-alt"></span>
                            </a>
                            <a class="btn btn-success btn-xs" data-original-title="Редактировать анализ" title="" data-toggle="tooltip" href="?c={$module_config.alias}&id={$items[i].id}">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <a class="btn btn-danger btn-xs confirm" data-original-title="Анализ будет удален" title="" data-toggle="tooltip" href="?c={$module_config.alias}&action=remove-site&id={$items[i].id}">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </td>
                    </tr>
                {/section}
            </table>
        {else}
            Сайтов нет
        {/if}
    </div>
</div>

<div id="add-sites-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Добавление сайтов</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="config-form" class="form-horizontal" role="form">
                    <div class="alert alert-info">
                        <p>По одному сайту/странице на каждую строку</p>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <textarea style="height: 310px;" name="sites" id="sites" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-dark save-sites">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var modal = $("#add-sites-modal");
    $(".save-sites").click(function () {
        $(this).prepend(img_loader);
        $.ajax({
            type: "POST",
            data: "action=add-sites&sites=" + modal.find("#sites").val(),
            success: function(msg){
                img_loader.remove();
                msg = JSON.parse(msg);
                if (msg.count > 0){
                    location.reload();
                } else {
                    alert_info("Добавлено сайтов: " + msg.count);
                }
            }
        });
    });
</script>