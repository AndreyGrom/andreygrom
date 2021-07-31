<h1>Панель управления AG CMS</h1>
<div class="row">
<div class="col-sm-12">
    <div class="panel-group" role="tablist">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                <h4 class="panel-title">
                    Общая статистика
                    <a class="pull-right" data-toggle="collapse" href="#collapse1" aria-expanded="true"
                       aria-controls="collapseListGroup1">
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>

                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse in clearfix" style="padding: 10px" role="tabpanel"
                 aria-labelledby="collapseListGroupHeading1" aria-expanded="true">
                <div class="col-sm-3">
                    <a href="?c=pages">
                        <span class="glyphicon glyphicon-edit"></span>
                        Страницы: {$page_count}
                    </a>
                </div>
                <div class="col-sm-3">
                    <a href="?c=catalog">
                        <span class="glyphicon glyphicon-th-list"></span>
                        Каталог: {$catalog_count}
                    </a>
                </div>
                <div class="col-sm-3">
                    <a href="?c=comments">
                        <span class="glyphicon glyphicon-comment"></span>
                        Комментарии: {$comments_count}
                    </a>
                </div>
                <div class="col-sm-3">
                    <a href="?c=code">
                        <span class="glyphicon glyphicon-random"></span>
                        Коды: {$codes_count}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-group" role="tablist">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="collapseL2">
                <h4 class="panel-title">
                    <a href="?c=pages">Страницы</a>: недавно измененные
                    <a class="pull-right" data-toggle="collapse" href="#collapse2" aria-expanded="true"
                       aria-controls="collapse2">
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>

                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse in clearfix" style="padding: 10px" role="tabpanel"
                 aria-labelledby="collapseL2" aria-expanded="true">
                {section name=i loop=$pages}
                    <div class="col-sm-3">
                        <span>{$pages[i].DATE_EDIT}</span>
                    </div>
                    <div class="col-sm-9">
                        <span style="font-weight: bold"><a href="?c=pages&id={$pages[i].ID}">{$pages[i].TITLE}</a></span>
                    </div>
                {/section}

            </div>
        </div>
    </div>

    <div class="panel-group" role="tablist">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="collapseL3">
                <h4 class="panel-title">
                    <a href="?c=catalog">Каталог</a>: недавно измененные
                    <a class="pull-right" data-toggle="collapse" href="#collapse3" aria-expanded="true"
                       aria-controls="collapse3">
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>

                </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse in clearfix" style="padding: 10px" role="tabpanel"
                 aria-labelledby="collapseL3" aria-expanded="true">
                {section name=i loop=$catalog}
                    <div class="col-sm-3">
                        <span>{$pages[i].DATE_EDIT}</span>
                    </div>
                    <div class="col-sm-9">
                        <span style="font-weight: bold"><a href="?c=pages&id={$catalog[i].ID}">{$catalog[i].TITLE}</a></span>
                    </div>
                {/section}

            </div>
        </div>
    </div>
</div>
</div>