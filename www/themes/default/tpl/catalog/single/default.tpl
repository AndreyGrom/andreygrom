{include file="../../common/header.tpl" class = "item-catalog"}

<aside>
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <h2 class="page-title">{$item.title}</h2>
                {section name=i loop=$item.images}
                    <div class="catalog-image">
                        <a href="/upload/images/catalog/{$item.images[i].name}" class="fancybox">
                            <img src="/upload/images/catalog/{$item.images[i].name}" alt="{$item.title}">
                        </a>
                    </div>
                {/section}
                <div class="clearfix"></div>
                <div>{$item.content}</div>

                {if isset($comments_form)}
                    <h5><i class="fa fa-comment"></i> Есть что добавить или возникли вопросы? Пишите в комментариях!</h5>
                    <br/>
                    {$comments}
                    {$comments_form}
                {/if}
            </div>
        </div>
    </div>
</aside>

{include file="../../common/footer.tpl"}