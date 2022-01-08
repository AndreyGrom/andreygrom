<div class="form-horizontal" role="form">
    <div class="form-group">
        <div class="col-sm-12">
            {if $new}
                <span class="form-control">Сначала сохраните материал</span>
            {else}

            {/if}
        </div>
        {if !$new}
            <div class="col-sm-12">
                <h3>Файлы на сайте</h3>
                <div id="upload_file" class="btn btn-success btn-large"><span>Выбрать файл с компьютера<span></div>
                <br/>
                <br/>
                <div style="display:none;" id="upl_group">
                    <label class="control-label">Отображаемое имя:</label>
                    <input class="form-control" type="text" id="upl_name" style="/*display: none;*/"/>
                    <br/>
                    <div class="btn btn-success btn-large" id="upl">Отправить</div>
                    <br/>
                </div>
                <span id="status_file"></span>
                <div id="item-files">
                    <ul class="file-list clearfix">
                        {section name=i loop=$files}
                            {include file="file.tpl" file_item=$files[i]}
                        {/section}
                    </ul>
                </div>
            </div>
            <div class="col-sm-12">
                <h3>Внешние файлы</h3>
                <div class="form-group">
                    <div class="col-sm-12"><h4>Файл 1:</h4></div>
                    <div class="col-sm-1 control-label">Имя:</div>
                    <div class="col-sm-11">
                        <input value="{$item_file1_name}" name="file1_name" type="text" class="form-control">
                    </div>
                    <div class="col-sm-1 control-label">URL:</div>
                    <div class="col-sm-11">
                        <input value="{$item_file1}" name="file1" type="text" class="form-control">
                    </div>
                    <div class="clearfix"></div>
                    <hr/>
                </div>
                <div class="form-group">
                    <div class="col-sm-12"><h4>Файл 2:</h4></div>
                    <div class="col-sm-1 control-label">Имя:</div>
                    <div class="col-sm-11">
                        <input value="{$item_file2_name}" name="file2_name" type="text" class="form-control">
                    </div>
                    <div class="col-sm-1 control-label">URL:</div>
                    <div class="col-sm-11">
                        <input value="{$item_file2}" name="file2" type="text" class="form-control">
                    </div>
                    <div class="clearfix"></div>
                    <hr/>
                </div>
                <div class="form-group">
                    <div class="col-sm-12"><h4>Файл 3:</h4></div>
                    <div class="col-sm-1 control-label">Имя:</div>
                    <div class="col-sm-11">
                        <input value="{$item_file3_name}" name="file3_name" type="text" class="form-control">
                    </div>
                    <div class="col-sm-1 control-label">URL:</div>
                    <div class="col-sm-11">
                        <input value="{$item_file3}" name="file3" type="text" class="form-control">
                    </div>
                    <div class="clearfix"></div>
                    <hr/>
                </div>
            </div>
            <script>
                $(function(){
                    var btnUpload=$('#upload_file');
                    var status=$('#status_file');
                    var au = new AjaxUpload(btnUpload, {
                        action: '{$html_controllers_dir}catalog/upload.php?id={$item_id}',
                        name: 'file',
                        autoSubmit: false,
                        onSubmit: function(file, ext){
                            status.text('Загрузка...');
                        },
                        onComplete: function(file, response){
                            status.text('');
                            $("#upl_group").hide();
                            //alert(response);
                            if(response !==""){
                                $(".file-list").append(response);
                            } else{
                                $('<li></li>').appendTo('#files').text(file).addClass('error');
                            }
                        },
                        onChange: function(file, response){
                            $("#upl_name").val(file);
                            $("#upl_group").show();
                        }
                    });
                    $("#upl").click(function(){
                        var d_name = $("#upl_name").val();
                        {literal}au._settings.data = {DisplayName:d_name};{/literal}
                        au.submit();
                    });
                    jQuery('body').on('click', 'a.del-file', function(e) {
                        e.preventDefault();
                        var el = $(this);
                        var file = el.attr("href");
                        $.ajax({
                            type: "POST",
                            url: "{$html_controllers_dir}catalog/upload.php",
                            data: "id={$item_id}&file="+file,
                            success: function(msg){
                                el.parent().remove();
                            }
                        });
                    });
                });
            </script>
        {/if}
    </div>
</div>
