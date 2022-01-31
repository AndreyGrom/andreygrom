<h1>Панель управления AG CMS</h1>

<div class="row">
    <div class="col-md-6">
        <table class="table table-hover table-inverse">
            <caption>Информация о сервере</caption>
            {if property_exists($details, 'ip')}
            <tr>
                <td>IP:</td>
                <td>{$details->ip}</td>
            </tr>
            {/if}
            {if property_exists($details, 'hostname')}
            <tr>
                <td>Имя хоста:</td>
                <td>{$details->hostname}</td>
            </tr>
            {/if}
            {if property_exists($details, 'city')}
            <tr>
                <td>Город:</td>
                <td>{$details->city}</td>
            </tr>
            {/if}
            {if property_exists($details, 'region')}
            <tr>
                <td>Регион:</td>
                <td>{$details->region}</td>
            </tr>
            {/if}
            {if property_exists($details, 'country')}
            <tr>
                <td>Страна:</td>
                <td>{$details->country}</td>
            </tr>
            {/if}
            {if property_exists($details, 'org')}
            <tr>
                <td>Организация:</td>
                <td>{$details->org}</td>
            </tr>
            {/if}
            {if property_exists($details, 'timezone')}
            <tr>
                <td>Часовой пояс:</td>
                <td>{$details->timezone}</td>
            </tr>
            {/if}
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-hover table-inverse">
            <caption>Информация о вас</caption>
            {if property_exists($details2, 'ip')}
            <tr>
                <td>IP:</td>
                <td>{$details2->ip}</td>
            </tr>
            {/if}
            {if property_exists($details2, 'hostname')}
            <tr>
                <td>Имя хоста:</td>
                <td>{$details2->hostname}</td>
            </tr>
            {/if}
            {if property_exists($details2, 'city')}
            <tr>
                <td>Город:</td>
                <td>{$details2->city}</td>
            </tr>
            {/if}
            {if property_exists($details2, 'region')}
            <tr>
                <td>Регион:</td>
                <td>{$details2->region}</td>
            </tr>
            {/if}
            {if property_exists($details2, 'country')}
            <tr>
                <td>Страна:</td>
                <td>{$details2->country}</td>
            </tr>
            {/if}
            {if property_exists($details2, 'org')}
            <tr>
                <td>Организация:</td>
                <td>{$details2->org}</td>
            </tr>
            {/if}
            {if property_exists($details2, 'timezone')}
            <tr>
                <td>Часовой пояс:</td>
                <td>{$details2->timezone}</td>
            </tr>
            {/if}
        </table>
    </div>
</div>

<div id="map" style="width: 100%;height: 400px;"></div>
<script src="https://api-maps.yandex.ru/2.1/?apikey=&lang=ru_RU" type="text/javascript"></script>
<script>
    ymaps.ready(init);
    function init(){
        var myMap;
        myMap = new ymaps.Map("map", {
            center: [{$details2->loc}],
            zoom: 13
        });
        myPlacemark = new ymaps.Placemark([{$details2->loc}], {
            hintContent: '{$details2->org}',
            balloonContent: '{$details2->org}'
        });
        myMap.geoObjects.add(myPlacemark);
    }
</script>
{*
<div class="row">
<div class="col-sm-12">
    <div class="panel-group" role="tablist">
        <div class="panel panel-default">
            <div class="thumb-wrap">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/hJtlv8EG3Dk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>


</div>
</div>*}
