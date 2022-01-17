{include file="../common/header.tpl" class = "main-catalog"}

<aside>
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="row">
                    {section name=i loop=$categories}
                        <div class="col-sm-4">
                            <div class="catalog-item">
                                <div class="catalog-item-img">
                                    <a href="/catalog/{$categories[i].alias}">
                                        <img src="/upload/images/catalog/{$categories[i].image}" alt="">
                                    </a>
                                </div>
                                <div class="catalog-item-title">
                                    <a href="/catalog/{$categories[i].alias}">
                                        {$categories[i].title}
                                    </a>
                                </div>
                            </div>
                        </div>
                    {/section}
                </div>
            </div>
            <div class="col-sm-9">

            </div>
        </div>
    </div>
</aside>

{include file="../common/footer.tpl"}