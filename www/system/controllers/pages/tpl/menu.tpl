<div class="panel-group hidden-sm hidden-xs" role="tablist">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
            <h4 class="panel-title">
                <span class="glyphicon glyphicon-edit"></span>
                <a class="" data-toggle="collapse" href="#collapseListGroup1" aria-expanded="true"
                   aria-controls="collapseListGroup1">Страницы сайта</a>
                <span class="caret"></span>
                <a class="btn btn-info btn-xs" data-target="" data-toggle="tooltip" href="?c={$module_alias}&act=new">
                    <span class="glyphicon glyphicon-plus"></span>
                    Создать страницу
                </a>
                <a class="btn btn-info btn-xs" href="?c={$module_alias}&act=settings"><span class="glyphicon glyphicon-cog"></span></a>
            </h4>
        </div>
        <div id="collapseListGroup1" class="panel-collapse collapse in" role="tabpanel"
             aria-labelledby="collapseListGroupHeading1" aria-expanded="true">

            {if ($menu)}
                {$menu}
            {/if}
        </div>

    </div>
</div>