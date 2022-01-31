
<div class="row">
    <div class="col-sm-12">
        {if !isset($item)}
            <span class="form-control">Сначала сохраните материал</span>
        {else}
            <a id="upload-images" href="#" class="btn btn-dark">Выбрать файлы</a>
            <span id="upload-images-status"></span>
        {/if}
    </div>
</div>
{if isset($item)}
    <div class="row">
        <div class="col-sm-12">
            <div id="item-images">
                <ul class="image-list clearfix">
                    {section name=i loop=$item.images}
                        {include file="image.tpl" img=$item.images[i].name img_id = $item.images[i].id skin = $item.skin}
                    {/section}
                </ul>
            </div>
        </div>
    </div>
{/if}


