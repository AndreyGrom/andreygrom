<style>
    tbody tr{
        cursor:pointer;
    }
</style>
<div class="panel panel-dark">
    <div class="panel-heading">
        <h3 class="panel-title text-uppercase">
            <span class="glyphicon glyphicon-duplicate"></span>
            {if !$item}Создание новой формы{else}Редактирование формы{/if}
            <a href="?c=mailforms&id={$item.id}&action=remove-form" class="btn btn-danger btn-xs pull-right remove-confirm">
                <i class="glyphicon glyphicon-remove" aria-hidden="true"></i> Удалить форму
            </a>
        </h3>
    </div>
    <div class="panel-body">
        {if $item}
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>Дата создания: <br>{$item.date_create|date_format:"%D %T"}</td>
                        <td>Дата изменения: <br>{$item.date_edit|date_format:"%D %T"}</td>
                    </tr>
                </table>
            <hr/>
            <div class="row">
                <div class="col-sm-6">
                    <h4 id="item-name">{$item.name}</h4>
                    <p id="item-desc">{$item.desc}</p>
                </div>
                <div class="col-sm-6">
                    <p id="item-answer">{$item.answer}</p>
                    <p id="item-emails">{$item.emails}</p>
                    <p><a id="edit-mail-form" href="#">Редактировать</a></p>
                </div>
            </div>

            <hr>
            <h3>
                Поля формы
                <a href="#" data-toggle="modal" data-target="#add-mailform-field" class="btn btn-dark btn-xs pull-right">Добавить поле</a>
            </h3>
            {if $item.fields}
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Название</th>
                        <th>Тип</th>
                        <th>Значения</th>
                        <th>Подсказка</th>
                        <th>Обязательное</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    {section name=i loop=$item.fields}
                        <tr>
                            <td>{$item.fields[i].id}</td>
                            <td>{$item.fields[i].name}</td>
                            <td>{$item.fields[i].type}</td>
                            <td>{$item.fields[i].values}</td>
                            <td>{$item.fields[i].placeholder}</td>
                            <td>{if $item.fields[i].required == 1}Да{else}Нет{/if}</td>
                            <td><a class="remove-confirm" href="?c=mailforms&id={$item.id}&action=remove-field&subid={$item.fields[i].id}"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i></a></td>
                        </tr>
                    {/section}
                    </tbody>
                </table>
            {/if}
        {/if}
    </div>
</div>

<div id="add-mailform-field" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Поле формы</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="0">
                    <div class="form-group">
                        <label>Название поля</label>
                        <input name="name" required type="text" class="form-control" placeholder="Название">
                    </div>
                    <div class="form-group">
                        <label>Тип поля</label>
                        <select id="type" name="type" class="form-control">
                            <option value="text">Строка (text)</option>
                            <option value="email">E-mail (email)</option>
                            <option value="number">Число (number)</option>
                            <option value="tel">Телефон (tel)</option>
                            <option value="password">Пароль (password)</option>
                            <option value="textarea">Многострочный текст (textarea)</option>
                            <option value="checkbox">Флажок (checkbox)</option>
                            <option value="radio">Опция (radio)</option>
                            <option value="select">Список выбора (select)</option>
                        </select>
                    </div>
                    <div class="form-group" id="values-group" style="display: none">
                        <label>Значения. Каждое с новой строки</label>
                        <div class="help-block">Только для radio и select</div>
                        <textarea name="values" class="form-control" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Подсказка (placeholder)</label>
                        <input name="placeholder" type="text" class="form-control" placeholder="Подсказка">
                    </div>
                    <div class="form-group">
                        <label>Обязательное (required)</label>
                        <select id="required" name="required" class="form-control">
                            <option value="0">Нет</option>
                            <option value="1">Да</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button name="save-mailform-field" type="submit" class="btn btn-dark">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var modal = $("#add-mailform-field");
    var modal_form = $("#add-mailform");
    $("tbody tr td:not(:last-child)").click(function () {
        modal.modal("show");
        modal.find("input[name='id']").val($(this).parent().find("td").eq(0).text());
        modal.find("input[name='name']").val($(this).parent().find("td").eq(1).text());
        modal.find("#type  option[value='" + $(this).parent().find("td").eq(2).text() + "']").prop('selected', true);
        modal.find("textarea[name='values']").text($(this).parent().find("td").eq(3).text());
        modal.find("input[name='placeholder']").val($(this).parent().find("td").eq(4).text());
        if ($(this).parent().find("td").eq(5).text() == "Да"){
            modal.find("#required option[value=1]").prop('selected', true);
        } else {
            modal.find("#required option[value=0]").prop('selected', true);
        }
        init_type();
    });
    modal.on('show.bs.modal', function(e) {
        modal.find("input").val("");
        modal.find("textarea").text("");
        modal.find("#type  option[value='text']").prop('selected', true);
        modal.find("#required option[value=0]").prop('selected', true);
        init_type();
    });
    function init_type(){
        var t = $("#type").val();
        if (t === "radio" || t === "select"){
            $("#values-group").show();
        } else {
            $("#values-group").hide();
        }
    }
    $("#type").change(function () {
        init_type();
    });

    modal_form.on('show.bs.modal', function(e) {
        modal_form.find("input").val("");
        modal_form.find("textarea").text("");
        modal_form.find("#type  option[value='text']").prop('selected', true);
        $("#template option[value='vertical.tpl").prop('selected', true);
        modal_form.find("input[name='form_id']").val('0');
        init_type();
    });

    $("#edit-mail-form").click(function (e) {
        modal_form.modal("show");
        e.preventDefault();
        modal_form.find("input[name='form_id']").val('{$item.id}');
        modal_form.find("input[name='name']").val('{$item.name}');
        modal_form.find("textarea[name='desc']").text('{$item.desc}');
        modal_form.find("textarea[name='answer']").text('{$item.answer}');
        modal_form.find("input[name='emails']").val('{$item.emails}');
        $("#template option[value='{$item.template}']").prop('selected', true);

        init_type();
    });
</script>