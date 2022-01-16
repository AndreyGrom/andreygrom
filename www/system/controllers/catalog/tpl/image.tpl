<li>
    <a class="fancybox" href="/upload/images/{$module_config.alias}/{$img}">
        <img class="img-responsive" src="/upload/images/{$module_config.alias}/{$img}" alt=""/>
    </a>
    <p><a data-id="{$img_id}" class="remove-image-item" href="#">Удалить</a></p>
    <p>&nbsp;
        <a data-id="{$img_id}" class="skin-image-item" {if $skin == $img_id}style="display: none" {/if} href="{$image}">Главная</a>
    </p>
</li>