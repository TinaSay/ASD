/*
 * Copyright (c) Rustam
 */
var myMap;
var myPlacemark;

$(document).ready(function () {


    ymaps.ready(function () {

        ymaps.geocode('Москва').then(function (res) {
            myMap = new ymaps.Map('map', {
                center: res.geoObjects.get(0).geometry.getCoordinates(),
                zoom: 13,
                controls: ["fullscreenControl", "typeSelector", "zoomControl"],
                behaviors: ["multiTouch", "dblClickZoom", "rightMouseButtonMagnifier"]
            });
            $('.custom-tab-item').each(function () {
                if ($(this).hasClass('active')) {
                    var tab = $(this);


                    myMap.setCenter([tab.data('long'), tab.data('lat')], 13, {
                        checkZoomRange: true
                    });
                    myPlacemark = new ymaps.Placemark([tab.data('long'), tab.data('lat')], {
                        hintContent: tab.text(),
                        balloonContent: tab.text()
                    }, {
                        // Опции.
                        // Необходимо указать данный тип макета.
                        iconLayout: 'default#image',
                        // Своё изображение иконки метки.
                        iconImageHref: '/static/asd/img/map-icon.svg',
                        // Размеры метки.
                        iconImageSize: [33, 33],
                        // Смещение левого верхнего угла иконки относительно
                        // её "ножки" (точки привязки).
                        iconImageOffset: [-5, -22]
                    });

                    myMap.geoObjects.add(myPlacemark); //removeAll()
                }
            });

        });


    });


    $('.custom-tab-item').on('click', function (e) {
        e.preventDefault();
        var tabPanelObj = $(this);
        $('.custom-tab-item').removeClass('active');
        tabPanelObj.addClass('active');
        $('.section-contact').addClass('is_close');
        $('.' + tabPanelObj.find('a').data('tab')).removeClass('is_close');


        //var myMap = myPlacemark.getMap();
        myMap.geoObjects.removeAll();
        var myPlacemark = new ymaps.Placemark([tabPanelObj.data('long'), tabPanelObj.data('lat')], {
            hintContent: tabPanelObj.text(),
            balloonContent: tabPanelObj.text()
        }, {
            // Опции.
            // Необходимо указать данный тип макета.
            iconLayout: 'default#image',
            // Своё изображение иконки метки.
            iconImageHref: '/static/asd/img/map-icon.svg',
            // Размеры метки.
            iconImageSize: [33, 33],
            // Смещение левого верхнего угла иконки относительно
            // её "ножки" (точки привязки).
            iconImageOffset: [-5, -22]
        });
        myMap.geoObjects.add(myPlacemark); //removeAll()
        myMap.setCenter([tabPanelObj.data('long'), tabPanelObj.data('lat')]);
    });
});
