<form method="post" class="form-horizontal" id="comments-form">
    <div class="card">
        <div class="card-header">
            <i class="fa fa-pencil"></i> Добавьте свой комментарий!
        </div>
        <div class="card-body">
            <input type="hidden" name="username"/>
            <input type="text" name="useremail" style="width: 1px;height: 1px;padding:0;borde:none;"/>
            <input type="hidden" id="comment-parent" name="comment-parent" value="0"/>
            <div id="reply-panel" class="alert alert-info" style="display: none">
                <p>
                    Вы отвечаете пользователю <span id="reply-user-comment">Андрей Гром</span>
                    <a id="no-reply" href="#">Отменить</a>
                </p>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label class="control-label" for="comment"><i class="fa fa-comment"></i> Комментарий:</label>
                        <div class="">
                            <textarea style="height: 178px" required class="form-control" name="comment" id="comment"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="name"><i class="fa fa-user"></i> Имя:</label>
                        <div class="">
                            <input required type="text" class="form-control" name="name" id="name" placeholder="Введите имя">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email"><i class="fa fa-envelope"></i> Email:</label>
                        <div class="">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email (не публикуется)">
                        </div>
                    </div>
                    {if $captcha}
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-12 control-label">Код с картинки:</label>
                                <div class="col-sm-5">
                                    <input required value="" name="captcha" type="tel" class="form-control">
                                </div>
                                <div class="col-sm-7"><img style="cursor: pointer" class="img-responsive" id="captcha" src="{$html_plugins_dir}captcha/index.php?hash={$rand}&sn=comment" alt=""/></div>
                            </div>
                        </div>
                    {/if}
                    <div class="form-group">
                        <button id="add-comment" type="submit" class="btn-outline" style="width:100%;display:block">Добавить комментарий</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

