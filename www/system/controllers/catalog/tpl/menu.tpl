<div class="panel-group hidden-sm hidden-xs" role="tablist">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
            <h4 class="panel-title">
                <i class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></i> {$module_config.name}
                <div class="pull-right">
                    <a href="?c={$module_config.alias}&category_id=0" class="btn btn-dark btn-xs"><i class="fa fa-plus"></i> Категория</a>
                    <a href="?c={$module_config.alias}&material_id=0" class="btn btn-dark btn-xs "><i class="fa fa-plus"></i> Материал</a>
                </div>
            </h4>
        </div>
        <div>
            {if ($menu)}
                {$menu}
            {/if}
        </div>
    </div>
</div>