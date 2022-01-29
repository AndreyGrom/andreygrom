{include file="../../common/header.tpl" class = "item-catalog"}

<aside>
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <h2 class="page-title">Страница: {$item->url}</h2>
                {if property_exists($item, 'host')}
                    <p>Сайт: <strong>{$item->proto}{$item->host}</strong></p>
                {/if}
                {if property_exists($item, 'ssl')}
                    <div class="alert alert-success">Защищено сертификатом SSL (протокл https://)</div>
                {else}
                    <div class="alert alert-danger">Не защищено сертификатом SSL (протокл http://)</div>
                {/if}
                <p>Кодировка исходного кода (не тег meta[charset]): <strong>{$item->encoding}</strong></p>
                <p>Значение тега meta[charset]: <strong>{$item->charset}</strong></p>
                {if $item->encoding|lower == $item->charset|lower}
                    <div class="alert alert-success">Верно! Значение meta[charset] и реальная кодировка исходного кода
                        HTML совпадает
                    </div>
                {else}
                    <div class="alert alert-danger">Ошибка! значение meta[charset] и реальная кодировка исходного кода
                        HTML не совпадает
                    </div>
                {/if}
                <p>Длина исходного кода с пробелами: <strong>{$item->length_html}</strong></p>
                <p>Длина текста с пробелами(без html-тегов): <strong>{$item->length_plain}</strong></p>
                {if $item->ratio < 15}
                    <div class="alert alert-danger">
                        Ошибка! Соотношение HMTL/Текст: <strong>{$item->ratio}%</strong><br>
                        Должно быть больше 15%
                    </div>
                {else}
                    <div class="alert alert-success">
                        Верно! Соотношение HMTL/Текст: <strong>{$item->ratio}%</strong><br>
                        Должно быть больше 15%
                    </div>
                {/if}
                <p><strong>Title страницы:</strong></p>
                {if property_exists($item, 'title')}
                    <p>Title страницы: {$item->title[0]['content']}</p>
                    {if count($item->title) > 1}
                        <div class="alert alert-danger">
                            Ошибка: на странице должен быть только один тег title. Сейчас их {count($item->title)}
                        </div>
                        <p>&nbsp;</p>
                    {/if}
                    {if $item->title[0]['length'] >= 10 && $item->title[0]['length'] <= 70}
                        <div class="alert alert-success">
                            Длина тега title нормальная. Она должна быть от 10 до 70 символов
                        </div>
                    {else}
                        <div class="alert alert-danger">
                            Ошибка! Длина title должна быть от 10 до 70 символов. Сейчас длина
                            - {$item->title[0]['length']}
                        </div>
                        <p>&nbsp;</p>
                    {/if}
                {elseif property_exists($item, 'title') || $item->title == ''}
                    <div class="alert alert-danger">
                        Ошибка! Title не задан
                    </div>
                    <p>&nbsp;</p>
                {/if}


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