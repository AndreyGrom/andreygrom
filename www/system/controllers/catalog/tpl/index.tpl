<style>
    tbody tr{
        cursor:pointer;
    }
</style>

<div class="panel panel-dark">
    <div class="panel-heading">
        <h3 class="panel-title text-uppercase">{$module_config.title}</h3>
    </div>
    <div class="panel-body">
        <div class="alert alert-info alert-dark">
            <h4>Модуль: "{$module_config.title}"</h4>
            <p>Алиас: {$module_config.alias}</p>
            <p>Версия: {$module_config.version}</p>
            <p>Автор: <a href="mailto:{$module_config.author}">{$module_config.author}</a></p>
        </div>
    </div>
</div>

