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
    <p><b>Режим работы</b>: 08:00-19:00, ежедневно, без выходных </p>
    <p><b>Забор анализов</b>: 08:00-15:00, ежедневно, без выходных </p>


    <p>Проезд: Автобусная остановка «Школа», на первом этаже здания БТИ, напротив поворота к Поликлинике №2</p>
    <p>От ЖД-Автобусной станции Тучково — 1 остановка:</p>
    <div id="map" style="width: 100%; height: 300px;"></div>
    <div class="contact-img-line">
        <a style="max-width:500px;" href="/images/sd-med-tuchkovo-1024x576.jpg">
            <img class="img-responsive img-thumbnail"
                 src="/images/sd-med-tuchkovo-672x372.jpg"
                 alt="Медицинский центр Столичная диагностика Тучково">
        </a>
    </div>
</div>
