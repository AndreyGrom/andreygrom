{include file="../../common/header.tpl" class = "item-catalog"}

<aside>
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <h1 class="page-title">{$item.title}</h1>
                <div class="item-catalog-meta-data clearfix">
                    <ul class="item-rubrics pull-right">
                        <li>Рубрики:</li>
                        {section name=i loop=$item.parents}
                            <li><a href="/catalog/{$item.parents[i].alias}" title="{$item.parents[i].title}">{$item.parents[i].title}</a></li>
                        {/section}
                    </ul>
                    <div class="item-catalog-date pull-left">{$item.date_publ}</div>
                </div>
                {if $item.img_name}
                    <div class="item-catalog-image">
                        <img class="img-responsive" src="/upload/images/catalog/{$item.img_name}" alt="{$item.title}" title="{$item.title}">
                    </div>
                {/if}
                {*{section name=i loop=$item.images}
                    <div class="catalog-image">
                        <a href="/upload/images/catalog/{$item.images[i].name}" class="fancybox">
                            <img src="/upload/images/catalog/{$item.images[i].name}" alt="{$item.title}">
                        </a>
                    </div>
                {/section}*}
                <div class="clearfix"></div>
                <div>{$item.content}</div>
                {if $item.files}
                    <h5>Файлы для скачивания:</h5>
                    <ul class="catalog-files">
                        {section name=i loop=$item.files}
                            <li>
                                <a target="_blank" href="/upload/files/catalog/{$item.files[i].name}">
                                    {$item.files[i].desc}
                                </a>
                            </li>
                        {/section}
                    </ul>
                {/if}
                <div class="item-catalog-meta-data clearfix">
                    <div class="item-catalog-date pull-left">{$item.date_publ}</div>
                    <div class="clearfix"></div>
                    {if $item.tags}
                        <ul class="item-tags">
                            <li>Метки:</li>
                            {section name=i loop=$item.tags}
                                <li><a href="/catalog/tag={$item.tags[i].name}">{$item.tags[i].name}</a></li>
                            {/section}
                        </ul>
                    {/if}
                    <div class="clearfix"></div>
                    <ul class="item-rubrics">
                        <li>Рубрики:</li>
                        {section name=i loop=$item.parents}
                            <li><a href="/catalog/{$item.parents[i].alias}">{$item.parents[i].title}</a></li>
                        {/section}
                    </ul>
                    <p>&nbsp;</p>
                </div>
                {include file="../../common/socials.tpl"}
                <p>&nbsp;</p>
                <h5>Вам будет интересно:</h5>
                <ul class="others-items check">
                    {section name=i loop=$others}
                        <li><a href="/catalog/{$others[i].alias}">{$others[i].title}</a></li>
                    {/section}
                </ul>
                <p>&nbsp;</p>
                {include file="../../common/pay.tpl"}
                <p>&nbsp;</p>

                {if isset($comments_form)}
                    <h5><i class="fa fa-comment"></i> Есть что добавить или возникли вопросы? Пишите в комментариях!</h5>
                    {$comments}
                    {$comments_form}
                {/if}
            </div>
            <div class="col-sm-3">
                {include file="../../common/sidebar-right.tpl"}
            </div>
        </div>
    </div>
</aside>

{include file="../../common/footer.tpl"}