<form id="page-form" action="" method="post">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase">{$module_config.title}</h3>
        </div>
        <div class="panel-body">
            <p><a href="?c={$module_config.alias}&id=0" class="btn btn-dark">Создать страницу</a></p>
            <div class="alert alert-info alert-dark">
                <h4>Модуль: "{$module_config.title}"</h4>
                <p>Алиас: {$module_config.alias}</p>
                <p>Версия: {$module_config.version}</p>
                <p>Автор: <a href="mailto:{$module_config.author}">{$module_config.author}</a></p>
            </div>
        </div>
    </div>
</form>
