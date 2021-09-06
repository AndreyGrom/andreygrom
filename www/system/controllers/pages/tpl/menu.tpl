<div class="panel-group hidden-sm hidden-xs" role="tablist">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
            <h4 class="panel-title">
                <i class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></i> {$module_config.name}
            </h4>
        </div>
        <p><a href="?c={$module_config.alias}&id=0" class="btn btn-dark">Создать страницу</a></p>
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