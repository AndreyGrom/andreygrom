<form id="page-form" action="" method="post">
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
            {if $messages}
                <h3>Сообщения</h3>
                <table class="table table-hover">
                    <tr>
                        <th>Форма</th>
                        <th>Принятое</th>
                        <th>Дата</th>
                        <th>IP адрес</th>
                        <th></th>
                    </tr>
                    {section name=i loop=$messages}
                        <tr>
                            <td>{$messages[i].name}</td>
                            <td>{$messages[i].body}</td>
                            <td>{$messages[i].date|date_format:"%D %T"}</td>
                            <td>{$messages[i].ip}</td>
                            <td><a class="remove-confirm" href="?c=mailforms&id={$messages[i].id}&action=remove-message"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i></a></td>
                        </tr>
                    {/section}
                </table>
            {/if}
        </div>
    </div>
</form>
