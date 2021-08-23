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
        <div class="alert alert-danger">
            <h3><i class="glyphicon glyphicon-info-sign" aria-hidden="true"></i> Вносите изменения, только если понимаете что делаете!</h3>
        </div>
        <div class="text-right">
            <a class="btn btn-dark" href="#" data-toggle="modal" data-target="#config-agcms"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Добавить параметр</a>
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Параметр</th>
                <th>Значение</th>
                <th>Описание</th>
                <th></th>
            </tr>
            </thead>
            {section name=i loop=$items}
                <tbody>
                <tr>
                    <td>{$items[i].param}</td>
                    <td>{$items[i].value}</td>
                    <td>{$items[i].desc}</td>
                    <td><a class="remove-confirm" href="?c=config&action=del&param={$items[i].param}"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i></a></td>
                </tr>
                </tbody>
            {/section}
        </table>
    </div>
</div>


<div id="config-agcms" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Редактирование параметра сайта</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="config-form" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label">Параметр:</label>
                        <div class="col-sm-9">
                            <input required value="" name="param" id="param" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label">Значение:</label>
                        <div class="col-sm-9">
                            <textarea name="value" id="value" class="form-control" cols="2"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label">Описание:</label>
                        <div class="col-sm-9">
                            <textarea name="desc" id="desc" class="form-control" cols="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-dark save">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var modal = $("#config-agcms");
    $("tbody tr td:not(:last-child)").click(function () {
        modal.find("#param").val($(this).parent().find("td").eq(0).text());
        modal.find("#value").val($(this).parent().find("td").eq(1).text());
        modal.find("#desc").val($(this).parent().find("td").eq(2).text());
        modal.modal("show");
    });

    $(".save").click(function () {
        $(this).prepend('<img src="/system/design/img/load.gif">');
        $.ajax({
            type: "POST",
            data: "action=set&param=" + modal.find("#param").val() + "&value=" + modal.find("#value").val() + "&desc=" + modal.find("#desc").val(),
            success: function(msg){
                if (msg == 1){
                    location.reload();
                }
            }
        });
    });
    function  SetConfig() {

    }
</script>
