<h1>Панель управления AG CMS</h1>

<div class="row">
    <div class="col-md-6">
        <table class="table table-hover table-inverse">
            <caption>Информация о сервере</caption>
            <tr>
                <td>IP:</td>
                <td>{$details->ip}</td>
            </tr>
            <tr>
                <td>Имя хоста:</td>
                <td>{$details->hostname}</td>
            </tr>
            <tr>
                <td>Город:</td>
                <td>{$details->city}</td>
            </tr>
            <tr>
                <td>Регион:</td>
                <td>{$details->region}</td>
            </tr>
            <tr>
                <td>Страна:</td>
                <td>{$details->country}</td>
            </tr>
            <tr>
                <td>Организация:</td>
                <td>{$details->org}</td>
            </tr>
            <tr>
                <td>Часовой пояс:</td>
                <td>{$details->timezone}</td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-hover table-inverse">
            <caption>Информация о вас</caption>
            <tr>
                <td>IP:</td>
                <td>{$details2->ip}</td>
            </tr>
            <tr>
                <td>Имя хоста:</td>
                <td>{$details2->hostname}</td>
            </tr>
            <tr>
                <td>Город:</td>
                <td>{$details2->city}</td>
            </tr>
            <tr>
                <td>Регион:</td>
                <td>{$details2->region}</td>
            </tr>
            <tr>
                <td>Страна:</td>
                <td>{$details2->country}</td>
            </tr>
            <tr>
                <td>Организация:</td>
                <td>{$details2->org}</td>
            </tr>
            <tr>
                <td>Часовой пояс:</td>
                <td>{$details2->timezone}</td>
            </tr>
        </table>
    </div>
</div>
<div id="map" style="width: 100%;height: 400px;"></div>
<script src="https://api-maps.yandex.ru/2.1/?apikey=a6156bac-50fa-492f-8998-943244fe3de3&lang=ru_RU" type="text/javascript"></script>
<script>
    ymaps.ready(init);
    var myMap;

    function init(){
        myMap = new ymaps.Map("map", {
            center: [46.334949, 48.042288],
            zoom: 16
        });

        myPlacemark = new ymaps.Placemark([46.334949, 48.042288], {
            hintContent: 'На здоровье, сеть аптек, 1 этаж!',
            balloonContent: 'На здоровье, сеть аптек, 1 этаж'
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
