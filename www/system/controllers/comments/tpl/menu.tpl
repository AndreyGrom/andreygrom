<div class="panel-group {*hidden-sm hidden-xs*}" role="tablist">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="module_{$module_name}_heading">
            <h4 class="panel-title">
                <i class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></i>
                Комментарии
            </h4>
        </div>
        <div id="collapseListGroup1" class="panel-collapse collapse in" role="tabpanel"
             aria-labelledby="module_{$module_name}_heading" aria-expanded="true">
            <ul class="nav">
                <li><a href="?c=comments"><span class="glyphicon glyphicon-chevron-right"></span> Все модули</a></li>
                {section name=i loop=$controllers}
                    <li><a href="?c=comments&module={$controllers[i].controller}"><span class="glyphicon glyphicon-chevron-right"></span> {$controllers[i].name}</a></li>
                {/section}
            </ul>
        </div>
    </div>
</div>