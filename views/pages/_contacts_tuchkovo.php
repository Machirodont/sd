<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=fded478f-6fae-46da-80eb-b4de8e3c29c7"
        type="text/javascript"></script>
<script type="text/javascript">
    ymaps.ready(function () {
        let coordinates = [55.600869, 36.462906];
        var moscow_map = new ymaps.Map("map", {
            center: coordinates,
            zoom: 15,
            controls: ['smallMapDefaultSet']
        });
        moscow_map.geoObjects.add(new ymaps.Placemark(coordinates, {
            balloonContent: 'ООО "Столичная диагностика"<br>г. Тучково, ул. Лебеденко, д. 21<br>+7(915) 480-03-03',
            iconCaption: 'Столичная диагностика'
        }, {
            preset: 'islands#dotIcon',
            iconCaptionMaxWidth: '150',
            iconColor: '#0b00ff'
        }));
    });
</script>
<div>
    <p>Адрес: <a href="https://yandex.ru/maps/-/CBU-5UfnGB">г. Тучково, ул. Лебеденко, д. 21</a></p>
    <p>Телефон: <a href="tel:+7(915) 480-03-03">+7(915) 480-03-03</a></p>


    <p>Проезд: Автобусная остановка «Школа», на первом этаже здания БТИ, напротив поворота к Поликлинике №2</p>
    <p>От ЖД-Автобусной станции Тучково — 1 остановка:</p>
    <div class="text-center">
        <a style="max-width:500px;" href="/uploads/2016/01/IMG_7295-1024x1024.jpg">
            <img class="img-responsive img-thumbnail" style="max-width:400px;"
                 src="/uploads/2016/01/IMG_7295-1024x1024.jpg"
                 alt="Медицинский центр Столичная диагностика Тучково"
                 srcset="/uploads/2016/01/IMG_7295-1024x1024.jpg 1024w, /uploads/2016/01/IMG_7295-1024x1024-300x225.jpg 300w"
                 sizes="(max-width: 1024px) 100vw, 1024px">
        </a>
    </div>
    <div id="map" style="width: 100%; height: 300px;"></div>
</div>
