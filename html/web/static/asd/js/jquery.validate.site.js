var formCooperationValidator;
$(document).ready(function () {

    // общие действия при проверке
    jQuery.validator.setDefaults({
        // добавляем класс к обертке у элементов формы при валидации
        highlight: function (element, errorClass, validClass) {
            $(element).closest(".form-group")
                .removeClass(validClass)
                .addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest(".form-group")
                .removeClass(errorClass)
                .addClass(validClass);
        }
    });


    // буквы
    jQuery.validator.addMethod("is_letter", (function (value, element, param) {
        var letter;
        letter = value.match(/^[а-яёa-z ]+$/gi);
        return this.optional(element) || letter;
    }), "Это поле может содержать только буквы");

    // телефон
    jQuery.validator.addMethod("is_tel", (function (value, element, param) {
        var tel;
        tel = value.match(/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/);
        return this.optional(element) || tel;
    }), "Введите коректный номер");

    // часы
    jQuery.validator.addMethod("is_hour", function (value, element, param) {
        var hour;
        hour = (value <= 21 && value >= 9);
        return this.optional(element) || hour;
    }, "Пожалуйста, введите время ввиде от 09 до 21");

    // минуты
    jQuery.validator.addMethod("is_minute", function (value, element, param) {
        var minute;
        minute = (value <= 59 && value >= 0);
        return this.optional(element) || minute;
    }, "Пожалуйста, введите время ввиде от 00 до 59");

    var time = 5000;


    $('#formTel input.time-check').change(function () {
        if ($(this).hasClass('accurate-time')) {
            $('.accurate-time-box').addClass('active');
        }
        else {
            $('.accurate-time-box').removeClass('active');
        }
    });

    // масква на телефон
    $('input.tel-mask').inputmask({mask: "+7 (999) 999 99 99"});

    // валидация формы заявки
    $('#formRequest').validate({
        rules: {
            'Feedback[fio]': {
                is_letter: true
            },
            'Feedback[phone]': {
                is_tel: true
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                btn = $form.find('.form-btn'),
                status = $form.find('.form-status'),
                loader = $form.find('.loader');
            loader.fadeIn(300);
            $.ajax({
                url: '/feedback/default/ajax',
                data: {
                    'Feedback[fio]': $form.find('input[name="Feedback[fio]"]').val(),
                    'Feedback[phone]': $form.find('input[name="Feedback[phone]"]').val(),
                    'Feedback[msg_type]': $form.find('input[name="Feedback[msg_type]"]').val(),
                    'Feedback[route]': $form.find('input[name="Feedback[route]"]').val(),
                    'Feedback[city]': $('#feedback-city-from-menu-mini-index').val(),
                    'Feedback[country]': window.utils.Cookie.get('country_ru')
                },
                dataType: "json",
                type: "POST",
                success: function (data) {
                    if (data.success === true) {

                        setTimeout(function () {
                            $form.get(0).reset();
                            $('#feedback-city-from-menu-mini-index').val(window.utils.Cookie.get('city_ru'));
                        }, 100);

                        btn.hide();
                        status.show();

                        setTimeout(function () {
                            loader.fadeOut(300);
                        }, 50);

                        setTimeout(function () {
                            status.hide();
                            btn.show();

                        }, time);
                    }
                }
            });


        }
    });
    $(window).on('yamaps.geolocation.found', function () {
        $('#feedback-city-from-menu-mini-index').val(window.utils.Cookie.get('city_ru'));
        $('#feedback-city').val(window.utils.Cookie.get('city_ru'));
        $('#feedback-city-from-menu').val(window.utils.Cookie.get('city_ru'));
    });
    $('#feedback-city-from-menu-mini-index').val(window.utils.Cookie.get('city_ru'));

    // валидация формы подписки
    var formSubscriptionValidator = $('#formSubscription').validate({

        rules: {
            "mail": {
                email: true
            }
        },
        submitHandler: function (form) {
            var _form = $(form),
                btn = _form.find('.form-btn'),
                status = _form.find('.form-status'),
                loader = _form.find('.loader');

            loader.fadeIn(300);

            ymaps.ready(function () {

                ymaps.geolocation.get({
                    // Зададим способ определения геолокации
                    // на основе ip пользователя.
                    provider: 'yandex',
                    // Включим автоматическое геокодирование результата.
                    autoReverseGeocode: true
                }).then(function (result) {
                    // Выведем результат геокодирования.
                    var geo = result.geoObjects.get(0).properties.get('metaDataProperty').GeocoderMetaData.AddressDetails.Country;

                    window.utils.Cookie.set('city_ru', geo.AddressLine, 3600, '/');
                    window.utils.Cookie.set('country_ru', geo.CountryName, 3600, '/');
                    $.ajax({
                        url: '/ru-RU/news/subscribe/ajax',
                        data: {
                            'Subscribe[email]': $('input[name="mail"]').val(),
                            'Subscribe[city]': geo.AddressLine,
                            'Subscribe[country]': geo.CountryName,
                            'Subscribe[type]': $('input[name="subscribeType"]').val(), // Subscribe::TYPE_SUBSCRIBE_???
                            'Subscribe[link]': document.location.href // current page url
                        },
                        dataType: "json",
                        type: "POST",
                        success: function (data) {
                            if (data.response.success === 1) {
                                $('#formSubscription').get(0).reset();
                                btn.hide();
                                status.show();
                                setTimeout(function () {
                                    loader.fadeOut(300);
                                }, 50);
                                setTimeout(function () {
                                    status.hide();
                                    btn.show();
                                }, time);
                            }
                        }
                    }); //ajax


                }); //ymaps.geolocation.get


            }); //ymaps.ready


        }
    });

    $('#subscribe-email-field').on('blur', function () {
        formSubscriptionValidator.form();
        $('#subscribe-email-field').on('keyup', function () {
            formSubscriptionValidator.form();
        });
    });


    // валидация формы заявки обр. звонка
    $('#formTel').validate({
        rules: {
            "Feedback[fio]": {
                is_letter: true
            },
            'Feedback[phone]': {
                is_tel: true
            },
            'timeHour': {
                is_hour: true
            },
            'timeMinute': {
                is_minute: true
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                data = $form.serialize(),
                loader = $form.find('.loader');

            $form.find('.help-block').hide();
            $form.find('label.error').remove();
            $form.find('.error').removeClass('error');

            if ($(form).data('loading') === true) {
                return false;
            }

            // additional data processing
            data += '&Feedback[callTime]=' + ($form.find('.accurate-time').is(':checked') ?
                $form.find('input[name="timeHour"]').val() + ':' + $form.find('input[name="timeMinute"]').val() :
                '');
            data += '&Feedback[city]=' + $('#feedback-city-from-menu-mini').val();
            data += '&Feedback[country]=' + window.utils.Cookie.get('country_ru');
            $form.data('loading', true);

            loader.fadeIn(300);

            $.ajax({
                url: $form.attr('action'),
                data: data,
                dataType: "json",
                type: "POST",
                success: function (data) {

                    $form.data('loading', false);
                    if (data.success) {

                        $form.find('.help-block').hide();
                        $form.find('.btn-and-info').hide();
                        $form.find('.form-status').show();

                        setTimeout(function () {
                            loader.fadeOut(300);
                        }, 50);

                        $form.find('label.error').remove();
                        $form.find('.error').removeClass('error');
                        $form.get(0).reset();
                        $('#feedback-city-from-menu-mini').val(window.utils.Cookie.get('city_ru'));
                        setTimeout(function () {
                            $form.find('.help-block').hide();
                            $form.find('.form-status').hide();
                            $form.find('.btn-and-info').show();
                            $form.find('label.error').remove();
                            $form.find('.error').removeClass('error');
                        }, 5000);
                    }
                }
            });


        }
    });
    $('#feedback-city-from-menu-mini').val(window.utils.Cookie.get('city_ru'));

    var fieldShow = false;
    $('#formBuy').on('focus blur', 'input', function (e) {
        if (!fieldShow) {
            var count = $(this).val().length;
            if (count === 0) {
                $(this).closest('form').find('.hide-form-group').slideDown();
                fieldShow = true;
            }
        }
    }).validate({
        rules: {
            "Feedback[fio]": {
                is_letter: true
            },
            'Feedback[phone]': {
                is_tel: true
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                btn = $form.find('.form-btn'),
                status = $form.find('.form-status'),
                loader = $form.find('.loader');

            $form.find('.help-block').hide();
            $form.find('label.error').remove();
            $form.find('.error').removeClass('error');

            if ($(form).data('loading') === true) {
                return false;
            }

            $form.find('button.btn-primary').text('Идёт отправка...');

            $form.data('loading', true);

            var data = $form.serialize();
            data += '&Feedback[country]=' + window.utils.Cookie.get('country_ru');

            loader.fadeIn(300);

            $.ajax({
                url: $form.attr('action'),
                data: data,
                dataType: "JSON",
                type: "POST",
                cache: false,
                success: function (data) {

                    $form.data('loading', false);
                    if (data.success) {
                        status.show();
                        setTimeout(function () {
                            status.hide();
                            btn.show();
                        }, time);

                        $form.get(0).reset();

                        setTimeout(function () {
                            loader.fadeOut(300);
                        }, 50);

                        setTimeout(function () {
                            $form.find('.help-block').hide();
                            $form.find('label.error').remove();
                            $form.find('.error').removeClass('error');
                        }, 150);
                    }
                }
            });
        }
    });


    $('#formFeedback').validate({
        rules: {
            "Feedback[fio]": {
                is_letter: true
            },
            "Feedback[email]": {
                email: true
            },
            'Feedback[phone]': {
                is_tel: true
            }
        },
        submitHandler: function (form) {
            if ($(form).data('loading') === true) {
                return false;
            }
            var $form = $(form),
                btn = $form.find('.form-btn'),
                status = $form.find('.form-status');
            $form.data('loading', true);

            var data = $form.serialize();
            data += '&Feedback[country]=' + window.utils.Cookie.get('country_ru');

            $.ajax({
                url: $form.attr('action'),
                data: data,
                dataType: "json",
                type: "POST",
                success: function (data) {
                    $form.data('loading', false);
                    if (data.success) {
                        setTimeout(
                            function () {
                                $form.get(0).reset();
                                $('#feedback-city').val(window.utils.Cookie.get('city_ru'));
                            }, 300);
                        btn.hide();
                        status.show();
                        $form.find('.error').hide();

                        setTimeout(function () {
                            status.hide();
                            btn.show();
                            $form.find('.error').hide();
                        }, time);

                    }
                }
            });


        }
    });
    $('#feedback-city').val(window.utils.Cookie.get('city_ru'));
});

function cooperationValidator() {
    if ((formCooperationValidator instanceof jQuery.validator) === false) {
        formCooperationValidator = createCooperationValidator();
    } else {
        formCooperationValidator.destroy();
        formCooperationValidator = createCooperationValidator();
    }
    return formCooperationValidator;
}

function createCooperationValidator() {
    var time = 5000;
    formCooperationValidator = $('#formCooperation').validate({
        debug: true,
        rules: {
            "Feedback[fio]": {
                is_letter: true
            },
            "Feedback[email]": {
                email: true
            },
            'Feedback[phone]': {
                is_tel: true
            }
        },

        submitHandler: function (form) {
            var $form = $(form),
                data = $form.serialize();
            // additional data processing
            data += '&Feedback[confirm]=1';
            data += '&Feedback[country]=' + window.utils.Cookie.get('country_ru');

            if ($form.data('loading') === true) {
                return false;
            }
            $form.data('loading', true);
            $form.find('.btn-primary').attr('disabled', true).text('Идёт отправка...');

            $.ajax({
                url: $form.attr('action'),
                data: data,
                dataType: "json",
                type: "POST",
                success: function (data) {
                    $form.data('loading', false);
                    if (data.success) {
                        setTimeout(
                            function () {
                                $form.get(0).reset();
                                $('#feedback-city-from-menu').val(window.utils.Cookie.get('city_ru'));
                            }, 300);

                        var btn = $form.find('.form-btn'),
                            status = $form.find('.form-status');

                        btn.hide();
                        status.show();

                        setTimeout(function () {
                            status.hide();
                            btn.show();
                            $form.find('.btn-primary').removeAttr('disabled').text('Получить предложение');
                        }, time);
                    }
                }
            });
        }
    }); // validator
    return formCooperationValidator;
}



