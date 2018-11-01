/**
 * detect script lang from location like a /en-US/index
 *
 * @returns {string}
 */
function getLangFromLocation() {
    var lang = 'ru_RU',
        regExp = new RegExp('https?:\/\/' + document.domain, 'i'),
        requestUri = document.location.href.replace(regExp, '');

    if (requestUri.match(/^(\/en-US+)/i)) {
        lang = 'en_US';
    }

    return lang;
}

// load yandex map js
var po = document.createElement('script');
po.type = 'text/javascript';
po.async = true;
po.src = 'https://api-maps.yandex.ru/2.1/?lang=' + getLangFromLocation();
po.id = 'yandex_map_script';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(po, s);
/*
ymaps.ready(function () {
    var myMap = new ymaps.Map('map', {
            center: [55.757982, 37.621319],
            zoom: 16,
            controls: ["fullscreenControl", "typeSelector", "zoomControl"],
            behaviors: ["drag", "multiTouch", "dblClickZoom", "rightMouseButtonMagnifier"]
        }),
        myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
            hintContent: 'Собственный значок метки',
            balloonContent: 'Это красивая метка'
        }, {
            // Опции.
            // Необходимо указать данный тип макета.
            iconLayout: 'default#image',
            // Своё изображение иконки метки.
            iconImageHref: 'img/map-icon.svg',
            // Размеры метки.
            iconImageSize: [33, 33],
            // Смещение левого верхнего угла иконки относительно
            // её "ножки" (точки привязки).
            iconImageOffset: [-5, -22]
        });
    myMap.geoObjects.add(myPlacemark);
});
*/