{if property_exists($item, 'images')}
    {section name=i loop=$item->images}
        <div class="row">
            <div class="col-sm-3">
                <img src="{$item->images[i].src}" alt="{$item->images[i].alt}" title="{$item->images[i].title}" class="img-fluid">
                <br><br>
            </div>
            <div class="col-sm-9">
                src: {$item->images[i].src}<br>
                alt: {$item->images[i].alt}<br>
                title: {$item->images[i].title}<br><br>
            </div>
        </div>
    {/section}
{else}
    <div class="alert alert-warning">Изображений на данной странице нет</div>
{/if}