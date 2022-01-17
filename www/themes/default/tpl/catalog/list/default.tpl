{include file="../../common/header.tpl" class = "main-catalog"}

<aside>
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <h2>{$category.title}</h2>
                <div class="row">
                    {if $items}
                        {section name=i loop=$items}
                            <div class="col-sm-4">
                                <div class="catalog-item">
                                    <div class="catalog-item-img">
                                        <a href="/catalog/{$items[i].alias}">
                                            <img src="/upload/images/catalog/{$items[i].imgname}" alt="">
                                        </a>
                                    </div>
                                    <div class="catalog-item-title">
                                        <a href="/catalog/{$items[i].alias}">
                                            {$items[i].title}
                                        </a>
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
            <div class="col-sm-9">

            </div>
        </div>
    </div>
</aside>

{include file="../../common/footer.tpl"}