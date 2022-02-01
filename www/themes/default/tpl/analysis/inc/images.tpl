{if property_exists($item, 'images')}
    {section name=i loop=$item->images}
        <div class="row">
            <div class="col-sm-3">
                <a class="fancybox" href="{$item->images[i]->src}" title="{$item->images[i]->alt}">
                    <img src="{$item->images[i]->src}" alt="{$item->images[i]->alt}" title="{$item->images[i]->title}" class="img-fluid">
                </a>
                <br><br>
            </div>
            <div class="col-sm-9">
                src: {$item->images[i]->src}<br>
                alt: {if $item->images[i]->alt}{$item->images[i]->alt}{else}<span class="text-danger">Нет альтернативного текста</span>{/if}<br>
                title: {$item->images[i]->title}<br><br>
            </div>
        </div>
    {/section}
{else}
    <div class="alert alert-warning">Изображений на данной странице нет</div>
{/if}