{include file="../../common/header.tpl" class = "main-catalog"}

<aside>
    <div class="container">
        <h2 class="page-title">{$category.title}</h2>
        <div class="row">
            <div class="col-sm-9">
                <div class="row">
                    {if $items}
                        {section name=i loop=$items}
                            <div class="col-sm-4">
                                <div class="catalog-item" onclick="document.location.href='/catalog/{$items[i].alias}'">
                                    <div class="catalog-item-img">
                                        {if $items[i].img_name}
                                        <a href="/catalog/{$items[i].alias}">
                                            <img src="/upload/images/catalog/{$items[i].img_name}" alt="{$items[i].title}" title="{$items[i].title}">
                                        </a>
                                        {/if}
                                    </div>
                                    <div class="catalog-item-title">
                                        <a href="/catalog/{$items[i].alias}">
                                            {$items[i].title}
                                        </a>
                                    </div>
                                    <div class="catalog-item-desc">
                                        {$items[i].short_content}
                                    </div>
                                </div>
                            </div>
                        {/section}
                    {else}
                        <div class="alert alert-danger">
                            <p>В данной категории ничего нет</p>
                        </div>
                    {/if}
                </div>
            </div>
            <div class="col-sm-3">
                {include file="../../common/sidebar-right.tpl"}
            </div>
        </div>
    </div>
</aside>

{include file="../../common/footer.tpl"}