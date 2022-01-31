<div class="form-horizontal" role="form">
    <div class="form-group">
        <div class="col-sm-12">
            {if !isset($item)}
                <span class="form-control">Сначала сохраните материал</span>
            {else}
                <a id="upload-files" href="#" class="btn btn-dark">Выбрать файлы</a>
                <span id="upload-files-status"></span>
            {/if}
        </div>
        {if isset($item)}
            <div class="col-sm-12">
                <div id="item-files">
                    <ul class="file-list clearfix">
                        {section name=i loop=$item.files}
                            {include file="file.tpl" file_name=$item.files[i].name file_id = $item.files[i].id desc = $item.files[i].desc}
                        {/section}
                    </ul>
                </div>
            </div>
        {/if}
    </div>
</div>