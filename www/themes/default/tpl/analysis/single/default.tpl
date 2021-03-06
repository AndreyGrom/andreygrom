{include file="../../common/header.tpl" class = "item-catalog"}

<aside>
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <h2 class="page-title">
                    Страница: {if isset($item)}{$item->url}{/if}
                </h2>
                <div class="card text-center">
                    <div class="card-header">
                        SEO-ОПТИМИЗАЦИЯ
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Показаны только поверхностные данные</h5>
                        <p class="card-text">Для более глубокого анализа закажите соответствующую услугу</p>
                        <a data-toggle="modal" data-target="#order-modal" href="#" class="btn btn-primary">Заказать SEO-оптимизацию</a>
                    </div>
                    <div class="card-footer text-muted">
                        Используется свой собственный алгоритм анализа страниц <a href="#"><strong>AG CMS ANALYSIS</strong></a>
                    </div>
                </div>

                {if isset($item)}
                    {include file="../inc/common.tpl"}
                    {include file="../inc/ratio.tpl"}
                    {include file="../inc/title.tpl"}
                    {include file="../inc/description.tpl"}
                    {include file="../inc/keywords.tpl"}
                    {include file="../inc/meta-og.tpl"}
                    {include file="../inc/meta-twitter.tpl"}


                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#links">Ссылки ({if property_exists($item, 'links')}{count($item->links)}{else}0{/if})</a>
                        </li>
                        {if property_exists($item, 'caption_tags')}
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#captions">Заголовки({if property_exists($item, 'caption_tags')}{$item->caption_tags->count}{else}0{/if})</a>
                        </li>
                        {/if}
                        {if property_exists($item, 'images')}
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#images">Изображения ({count($item->images)})</a>
                        </li>
                        {/if}
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#flash">Flash/Iframe</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="links">
                            <p>&nbsp;</p>
                            {include file="../inc/links.tpl"}
                        </div>
                        <div class="tab-pane fade" id="images">
                            <p>&nbsp;</p>
                            {include file="../inc/images.tpl"}
                        </div>
                        <div class="tab-pane fade" id="captions">
                            <p>&nbsp;</p>
                            {include file="../inc/captions.tpl"}
                        </div>
                        <div class="tab-pane fade" id="flash">
                            <p>&nbsp;</p>
                            {include file="../inc/flash.tpl"}
                        </div>
                    </div>
                {else}
                    <p>&nbsp;</p>
                    <div class="alert alert-danger">Страница еще не загружена. Зайдите попозже</div>
                {/if}
                <hr>

                {include file="../../common/socials.tpl"}
                <p>&nbsp;</p>
                <h5>Последние проанализированные страницы:</h5>
                <ul class="others-items check">
                    {section name=i loop=$others}
                        <li><a href="/catalog/{$others[i].alias}">{$others[i].title}</a></li>
                    {/section}
                </ul>
                <p>&nbsp;</p>
                {include file="../../common/pay.tpl"}
                <p>&nbsp;</p>

                {if isset($comments_form)}
                    <h5><i class="fa fa-comment"></i> Есть что добавить или возникли вопросы? Пишите в комментариях!
                    </h5>
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