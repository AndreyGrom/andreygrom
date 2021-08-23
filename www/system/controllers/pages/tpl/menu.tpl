<div class="panel-group hidden-sm hidden-xs" role="tablist">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
            <h4 class="panel-title">
                <i class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></i> {$module_config.name}
               {* <a class="btn btn-dark btn-xs" data-target="" data-toggle="tooltip" href="?c={$module_config.alias}&id=0">
                    <span class="glyphicon glyphicon-plus"></span>
                    Создать страницу
                </a>*}
            </h4>
        </div>
        <div class="alert alert-info alert-dark">
            <p>Алиас: {$module_config.alias}</p>
            <p>Версия: {$module_config.version}</p>
            <p>Автор: <a href="mailto:{$module_config.author}">{$module_config.author}</a></p>
        </div>
        <div>

            {if ($menu)}
                {$menu}
            {/if}
        </div>

    </div>
</div>