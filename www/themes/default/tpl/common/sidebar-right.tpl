{catalog_categories}
{if $catalog_categories}
<div class="card">
    {catalog_categories}
    <div class="card-header">
        <strong>Категории</strong>
    </div>
    <ul class="list-group list-group-flush">
        {section name=i loop=$catalog_categories}
        <li class="list-group-item">
            <a href="/catalog/{$catalog_categories[i].alias}">{$catalog_categories[i].title}</a>
        </li>
        {/section}
    </ul>
</div>
<p>&nbsp;</p>
{/if}

{catalog_last}
{if $catalog_last}
<div class="card">
    <div class="card-header">
        <strong>Свежии публикации</strong>
    </div>
    <ul class="list-group list-group-flush">
        {section name=i loop=$catalog_last}
            <li class="list-group-item">
                <a href="/catalog/{$catalog_last[i].alias}">{$catalog_last[i].title}</a>
            </li>
        {/section}
    </ul>
</div>
<p>&nbsp;</p>
{/if}

{comments_last}
{if $comments_last}
<div class="card">
    <div class="card-header">
        <strong>Последние комментарии</strong>
    </div>
    <ul class="list-group list-group-flush">
        {section name=i loop=$comments_last}
            <li class="list-group-item">
                <span><strong>{$comments_last[i].user_name}</strong></span><br>
                <a href="/{$comments_last[i].module}/{$comments_last[i].material_id}">{$comments_last[i].user_comment|truncate:30}</a>
            </li>
        {/section}
    </ul>
</div>
    <p>&nbsp;</p>
{/if}

    <div class="card">
        <div class="card-header">
            <strong>Пожертвовать на сайт</strong>
        </div>
        {include file="./pay.tpl"}
    </div>
    <p>&nbsp;</p>

<h6>Метки</h6>
<h6>Последние комментарии</h6>
<h6>Популярное</h6>
<h6>Интересное</h6>
<h6>Мини-чат</h6>
<h6>Форма авторизации</h6>
<h6>Баннеры</h6>