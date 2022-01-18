
<form id="page-form" action="" method="post">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase">
                <span class="glyphicon glyphicon-pencil"></span> Редактирование комментария
            </h3>
        </div>
        <div class="panel-body">
            <div class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="date" class="col-sm-3 control-label">Дата:</label>
                    <div class="col-sm-9">
                        <input value="{$item.date_publ}" name="date" id="date" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Имя:</label>
                    <div class="col-sm-9">
                        <input value="{$item.user_name}" name="name" id="name" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email:</label>
                    <div class="col-sm-9">
                        <input value="{$item.user_email}" name="email" id="email" type="text" class="form-control" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Комментарий:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="comment" id="comment" cols="30" rows="10">{$item.user_comment}</textarea>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button name="save-comment" id="save-comment" type="submit" class="btn btn-dark">Сохранить</button>
            </div>

        </div>
    </div>
</form>

