


<meta property="og:locale" content="ru_RU" />
{if $meta_image}
<meta property="og:image" content="{$meta_image}" />
{/if}
<meta property="og:type" content="website"/>
<meta property="profile:first_name" content="Андрей"/>
<meta property="profile:last_name" content="Гром"/>
<meta property="profile:username" content="grominfo"/>
<meta property="og:title" content="{$meta_title}"/>
<meta property="og:description" content="{$meta_description}"/>
{if $meta_image}
<meta property="og:image" content="{$meta_image}"/>
{/if}
<meta property="og:url" content="{$self_url}"/>
<meta property="og:site_name" content="{$config->SiteTitle}"/>
<meta property="og:see_also" content="{$self_url}"/>

<meta itemprop="name" content="{$meta_title}"/>
<meta itemprop="description" content="{$meta_description}"/>
{if $meta_image}
<meta itemprop="image" content="{$meta_image}"/>
{/if}

<meta name="twitter:card" content="summary"/>
<meta name="twitter:site" content="{$config->SiteTitle}"/>
<meta name="twitter:title" content="{$meta_title}">
<meta name="twitter:description" content="{$meta_description}"/>
<meta name="twitter:creator" content="{$config->SiteDirector}"/>
{if $meta_image}
<meta name="twitter:image:src" content="{$meta_image}"/>
{/if}
<meta name="twitter:domain" content="{$self_url}"/>