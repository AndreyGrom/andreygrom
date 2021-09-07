<div class="panel-group hidden-sm hidden-xs" role="tablist">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
            <h4 class="panel-title">
                <i class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></i> {$module_config.name}
                <div class="pull-right">
                    <a data-toggle="modal" data-target="#add-mailform" href="#" class="btn btn-dark btn-xs">Создать форму</a>
                    <a data-toggle="modal" data-target="#config-mail-modal" href="#" class=""><i class="glyphicon glyphicon-cog" aria-hidden="true"></i></a>
                </div>
            </h4>
        </div>

        <div>
            <ul class="nav">
                {section name=i loop=$forms}
                    <li>
                        <a href="?c={$module_config.alias}&id={$forms[i].id}" data-toggle="tooltip" title="{$forms[i].desc|strip_tags|truncate:300}"><span class="glyphicon glyphicon-text-size btn-xs"></span>{$forms[i].name}</a>
                    </li>
                {/section}
            </ul>

        </div>

    </div>
</div>

<div id="add-mailform" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Добавление новой формы</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="form_id" value="0">
                    <div class="form-group">
                        <input name="name" required type="text" class="form-control" placeholder="Название формы">
                    </div>
                    <div class="form-group">
                        <textarea name="desc" class="form-control" placeholder="Описание формы"></textarea>
                    </div>
                    <div class="form-group">
                        <textarea name="answer" class="form-control" placeholder="Сообщение после отправки"></textarea>
                    </div>
                    <div class="form-group">
                        <input name="emails" required type="text" class="form-control" placeholder="E-mail получателей (через запятую)">
                    </div>
                    <div class="form-group">
                        <label>Шаблон</label>
                        <select name="template" id="template" class="form-control">
                            {section name=i loop=$templates}
                                <option value="{$templates[i]}">{$templates[i]}</option>
                            {/section}
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button name="save-mailform" type="submit" class="btn btn-dark">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="config-mail-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Настройки почты</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Метод отправки</label>
                        <select name="MailSMTPEnabled" class="form-control">
                            <option value="0">Функция Mail</option>
                            <option value="1" {if $config->MailSMTPEnabled == 1}selected{/if}>Внешний SMTP</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Имя отправителя</label>
                        <input value="{$config->MailSMTPFromName}" name="MailSMTPFromName" required type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>SMTP Host</label>
                        <input value="{$config->MailSMTPHost}" name="MailSMTPHost" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>SMTP User</label>
                        <input value="{$config->MailSMTPUserName}" name="MailSMTPUserName" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>SMTP Password</label>
                        <input value="{$config->MailSMTPUserPassword}" name="MailSMTPUserPassword" type="text" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button name="save-mailform-settings" type="submit" class="btn btn-dark">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>