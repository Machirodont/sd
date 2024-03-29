<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=fded478f-6fae-46da-80eb-b4de8e3c29c7" type="text/javascript"></script>
<script type="text/javascript">
    ymaps.ready(function(){
        let coordinates=[55.557286, 34.992993];
        var moscow_map = new ymaps.Map("map", {
            center: coordinates,
            zoom: 15,
            controls: ['smallMapDefaultSet']
        });
        moscow_map.geoObjects.add(new ymaps.Placemark(coordinates, {
            balloonContent: 'ООО "Столичная диагностика"<br>г. Гагарин, ул. Солнцева, 22<br>+7(915) 650-03-03',
            iconCaption: 'Столичная диагностика'
        }, {
            preset: 'islands#dotIcon',
            iconCaptionMaxWidth: '150',
            iconColor: '#0b00ff'
        }));
    });
</script>
<div>
    <p>Телефон: <a href="tel:+7(915) 650-03-03">+7(915) 650-03-03</a></p>
    <p>Адрес: г. Гагарин, ул. Солнцева, 22</p>
    <p>Время работы медицинского центра с 8 до 18.00 ежедневно</p>

    <!--iframe src="https://yandex.ru/map-widget/v1/?z=17&amp;ol=biz&amp;oid=164658137923" frameborder="0"></iframe-->
    <div id="map" style="width: 100%; height: 300px;"></div>
</div>
