
<div class="panel panel-dark">
    <div class="panel-heading">
        <h3 class="panel-title text-uppercase">Категория каталога</h3>
    </div>

    <div class="panel-body">
        <form method="post" class="form-horizontal" role="form">
            <div class="form-group">
                <label for="title" class="col-sm-3 control-label">Название:</label>
                <div class="col-sm-9">
                    <input required value="{$category.title}" id="title" name="title" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="alias" class="col-sm-3 control-label">Алиас:</label>
                <div class="col-sm-9">
                    <input value="{$category.alias}" id="alias" name="alias" type="text" class="form-control" placeholder="Только символы a-z, A-Z, 0-9, -_ " />
                    <p class="help-block">Только символы a-z, A-Z, 0-9, -_ <br/>
                        Можно оставить пустым. Заполнится автоматически</p>
                </div>
            </div>
            <div class="form-group">
                <label for="content" class="col-sm-12">Краткое описание:</label>
                <div class="col-sm-12">
                    <textarea class="textarea-edit form-control" name="short_desc">{$page.short_content}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="content" class="col-sm-12">Полное описание:</label>
                <div class="col-sm-12">
                    <textarea class="textarea-edit" name="full-desc" style="width:100%;height:200px;">{$page.short_content}</textarea>
                </div>
            </div>
            <hr>
            <div class="pull-left">
                <a href="?c=pages" class="btn btn-default">Отмена</a>
            </div>
            <div class="pull-right">
                <button type="submit" name="save-category" class="btn btn-dark"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
            </div>
        </form>
    </div>
</div>

