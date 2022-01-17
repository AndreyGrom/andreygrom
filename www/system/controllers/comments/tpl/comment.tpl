
<form id="page-form" action="" method="post">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase">
                <span class="glyphicon glyphicon-pencil"></span> Редактирование комментария
                <div class="pull-right">
                    <a class="btn btn-xs btn-primary" href="?c=comments"><span class="glyphicon glyphicon-circle-arrow-left"></span> Список комментариев</a>
                </div>
            </h3>
        </div>
        <div class="panel-body">

            <div class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="date" class="col-sm-3 control-label">Дата:</label>
                    <div class="col-sm-9">
                        <input value="{$comment.DATE_PUBL}" name="date" id="date" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Имя:</label>
                    <div class="col-sm-9">
                        <input value="{$comment.USER_NAME}" name="name" id="name" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email:</label>
                    <div class="col-sm-9">
                        <input value="{$comment.USER_EMAIL}" name="email" id="email" type="text" class="form-control" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Комментарий:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="comment" id="comment" cols="30" rows="10">{$comment.USER_COMMENT}</textarea>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-success btn-large"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
            </div>

        </div>
    </div>
</form>
<script>
    tinymce.init({
        selector:'textarea',
        language : 'ru',
        //theme : "advanced",
        relative_urls : false,
        plugins: [
            "jbimages autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern"
        ],
        extended_valid_elements : 'embed[param|src|type|width|height|flashvars|wmode|allowscriptaccess|allowfullscreen],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],div[*],p[*],span[*],i[*],a[*],object[width|height|classid|codebase|embed|param],param[name|value]',
        media_strict: false,
        global_xss_filtering:true,
        menubar : false,
        toolbar1: "bold italic underline strikethrough |  alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote | link unlink anchor | image jbimages media | insertdatetime preview | forecolor backcolor | table | hr removeformat | subscript superscript | charmap emoticons | spellchecker | code"
    });
</script>
