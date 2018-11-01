$(document).ready(function () {

    $('.field-feedback-msg_type').hide();

    $('.check-confirm').change(function () {
        var check = $(this).prop('checked');
        if (check === true) {
            $(this).closest('.form-group-confirm').find('.btn-confirm').prop('disabled', false);
            return false;
        }
        else {
            $(this).closest('.form-group-confirm').find('.btn-confirm').prop('disabled', true);
            return false;
        }
    });


    var $request2;

    function cityAutocompliterInit() {

        /**
         * autocompleter class for ymap street geocoding
         */
        $(".autocompleter").on('blur', function () {
            var $el = $(this);
            setTimeout(function () {
                $el.parent().removeClass('open');
            }, 100);
        }).on('keyup', function (e) {

            var $el = $(this);
            var value = $el.val();
            if (value.length < 5) return false;
            e.stopPropagation();

            if ((value.length < 5) && (e.which === 8 || e.which === 46)) {// delete/backspace controls pressed
                $el.parent().removeClass('open');
                $el.next().empty();
                return true;
            }

            if (e.which === 40 || e.which === 38) {// left/right controls pressed
                return true;
            }


            if (e.which === 13 || e.which === 27) {// Enter/Esc controls pressed
                $el.blur();
                return false;
            }

            if (value.length <= 0 || $el.data('min') && value.length < $el.data('min')) {
                $el.parent().removeClass('open');
                return true;
            }

            if ($request2 != null) {
                $request2.abort();
                $request2 = null;
            }
            $request2 = $.ajax({
                url: 'https://geocode-maps.yandex.ru/1.x/?geocode=' +
                window.utils.Cookie.get('country_ru') +
                ', город ' + $el.val(),
                data: {'format': 'json', 'results': '10'},
                dataType: "json",
                type: "GET",
                success: function (data) {

                    if (data.response.GeoObjectCollection.metaDataProperty.GeocoderResponseMetaData.found > 0) {
                        var ymapsdata = data.response.GeoObjectCollection.featureMember;
                        //for (var i in ymapsdata) { alert(ymapsdata[i].GeoObject.name);  }
                    }

                    if (data.response.GeoObjectCollection.metaDataProperty.GeocoderResponseMetaData.found > 0) {
                        if ($el.next().is('.dropdown-menu')) {
                            $el.next().empty();
                        } else {
                            $('<ul class="dropdown-menu"></ul>').insertAfter($el);
                            var activeIndex = -1;
                            $(document).keydown(function (event) {
                                if ($('.open .dropdown-menu').length > 0) {
                                    var charCode = event.which;
                                    var UL = $('.open .dropdown-menu:last');

                                    switch (charCode) {
                                        case 13: // Enter
                                            if (UL.find('li.active').length > 0) {
                                                var option = UL.find('li.active a');
                                                $el.val(option.data('value'));
                                                $('#feedback-city').val(option.data('value'));
                                            }
                                            $el.parent().removeClass('open');
                                            break;
                                        case 27: // Esc
                                            $el.parent().removeClass('open');
                                            break;
                                        case 38: //Up
                                            event.preventDefault();
                                            if (activeIndex <= 0) activeIndex = 1;
                                            activeIndex--;
                                            UL.find('li').removeClass('active');
                                            UL.find('li:eq(' + activeIndex + ')').addClass('active');
                                            break;
                                        case 40: //Down
                                            event.preventDefault();
                                            activeIndex++;
                                            if (activeIndex > UL.find('li').length) activeIndex = UL.find('li').length - 1;
                                            UL.find('li').removeClass('active');
                                            UL.find('li:eq(' + activeIndex + ')').addClass('active');
                                            break;
                                    }
                                }
                            });

                            $el.next('.dropdown-menu').on('click', 'li a', function (e) {
                                e.preventDefault();
                                $el.val($(this).text().trim());
                                $('#feedback-city').val($(this).text().trim());
                                console.log('point', $el.val());
                                $el.parent().removeClass('open');
                            });
                        }
                        var UL = $el.next('.dropdown-menu');
                        var p = UL.position();
                        var elpos = $el.position();
                        //alert(p.top+' '+elpos.top);
                        UL.css({'top': elpos.top + 30, 'left': elpos.left, 'width': elpos.width});

                        for (var i in ymapsdata) {
                            //if (ymapsdata[i].GeoObject.metaDataProperty.GeocoderMetaData.kind == 'street') {
                            var item = ymapsdata[i].GeoObject;
                            item.lat = item.Point.pos.split(' ')[0];
                            item.lng = item.Point.pos.split(' ')[1];
                            UL.append('<li><a href="#"  data-id="' + '0' + '"' +
                                (item.lat ? 'data-lat="' + item.lat + '" ' : '') +
                                (item.lng ? 'data-lng="' + item.lng + '" ' : '') +
                                ' data-value="' + item.name + '">'
                                + item.name + '</a></li>');
                            //}
                        }
                        $el.parent().addClass('open');
                    } else {
                        $el.parent().removeClass('open');
                    }
                }
            });//ajax ends
        });
    }

    cityAutocompliterInit(); // on ready event

    function detectClientCity(geolocation) {
        geolocation.get({
            // Зададим способ определения геолокации
            // на основе ip пользователя.
            provider: 'yandex',
            // Включим автоматическое геокодирование результата.
            autoReverseGeocode: true
        }).then(function (result) {
            // Выведем результат геокодирования.
            var geo = result.geoObjects.get(0).properties.get('metaDataProperty').GeocoderMetaData.AddressDetails.Country;
            $('#feedback-city-from-menu').val(geo.AddressLine);
            $('#feedback-city').val(geo.AddressLine);//geo.CountryName
            $('#feedback-city-from-menu-mini').val(geo.AddressLine);
            $('#feedback-city-from-menu-mini-index').val(geo.AddressLine);
            window.utils.Cookie.set('country_ru', geo.CountryName, 3600, '/');
            window.utils.Cookie.set('city_ru', geo.AddressLine, 3600, '/');
            $(window).trigger('yamaps.geolocation.found', [geo.CountryName, geo.AddressLine]);
        });
    }

    ymaps.ready(function () {
        if (window.utils.Cookie.get('country_ru') === "") {
            if (!ymaps.geolocation) {
                ymaps.modules.require(['geolocation'], function (geolocation) {
                    setTimeout(function () {
                        detectClientCity(geolocation);
                    }, 300);
                });
            } else {
                setTimeout(function () {
                    detectClientCity(ymaps.geolocation);
                }, 300);
            }
        }
    });


    $('#input-date-hour').timepicker({
        hours: {
            starts: 9,
            ends: 21
        },
        rows: 4,
        showPeriodLabels: false,
        showPeriod: false,
        showMinutes: false
    });

    $('#input-date-minutes').timepicker({
        showHours: false
    });


    $('[data-href=page-cooperation]').on('click', function (event) {
        var $conteiner = $('#page-cooperation').find('.page-layer__inner');
        if ($conteiner.html() === '') {
            $.ajax(
                {
                    'url': '/feedback/ajax/cooperation',
                    'success': function (data) {
                        $('#page-cooperation').find('.page-layer__inner').html(data);
                        formCooperationValidator = cooperationValidator();
                        formCooperationValidator.resetForm();
                        $('input.check-confirm').styler();
                        cityAutocompliterInit();
                        if ($('#feedback-city-from-menu').val() === '') {
                            $('#feedback-city-from-menu').val(window.utils.Cookie.get('city_ru'));
                        }
                        $('#feedback-layer-two-open-btn').on('click', function (e) {
                            $('#feedback-call-layer-btn').trigger('click');
                        });
                    },
                    'cache': true
                    //,'data' : {'var':Math.random()} // для принудительного вызова ajax
                });
        }
        //setTimeout(cityAutocompliterInit(),300);
    });

}); // document.ready