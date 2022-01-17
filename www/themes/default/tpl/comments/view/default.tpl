<ul class="{if !$sub}comment-list{else}reply{/if}">
    {section name=i loop=$comments}
    <li id="comment-{$comments[i].id}" class="comment">
        <div class="comment-body">
            <div class="comment-meta">
                <span class="comment-user">
                    <i class="fa fa-user"></i>
                    <span class="comment-user-name">{$comments[i].user_name}</span>
                </span>
                <a href="{$comments[i].id}" class="comment-reply">
                    <i class="fa fa-reply"></i> Ответить
                </a>
                <span class="comment-date pull-right">
                    <i class="fa fa-clock-o"></i>
                    {$comments[i].date_publ}
                </span>
            </div>
            <div class="comment-text">{$comments[i].user_comment}</div>
        </div>
        {if $comments[i].sub}
            {include file=$tpl_name comments=$comments[i].sub sub=true}
        {/if}
    </li>
    {/section}
</ul>
