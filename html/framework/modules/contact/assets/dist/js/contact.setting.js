$(document).ready(function () {
    $('.contact-setting-btn-save').attr('disabled', true);

    checkFormErrors();


    $('#contact-setting-code').on('blur', checkPHONECODEField);

    $('#contact-setting-phone').on('blur', checkPHONEField);


    $('#contact-setting-form').find("input[aria-required='true'],textarea[aria-required='true']").each(function () {
        //alert( $(this).attr('id') );
        if (
            $(this).attr('id') != 'contact-setting-code'
            && $(this).attr('id') != 'contact-setting-phone'
        ) {
            $(this).on('blur', function () {
                checkRequiredField($(this));
            });
            $(this).on('keyup', function () {
                checkRequiredField($(this));
            });
        }
    });

    $('.contact-setting-btn-save').on('click', function () {
        if (checkFormErrors()) {
            $('#contact-setting-form').get(0).submit();
        }
    });


}); // document.ready

function checkFormErrors() {

    var errors = 0;
    $('#contact-setting-form').find("input[aria-required='true'],textarea[aria-required='true']").each(function () {
        if (!checkRequiredField($(this))) {
            errors++;
        }
    });

    if (!checkPHONEField()) errors++;

    if (!checkPHONECODEField()) errors++;


    if (errors <= 0) {
        return true;
    }
    return false;
}

function checkPHONEField() {
    rePHONE = /^([0-9\-)])+$/;
    var test = rePHONE.test($('#contact-setting-phone').val());
    if (!test || $('#contact-setting-phone').val() == '') {
        $('#contact-setting-phone').next().html('Укажите корректный номер телефона').show();
        $('#contact-setting-phone').parent().addClass('has-error');
        $('.contact-setting-btn-save').attr('disabled', true);
        var ret = false;
        //console.log(test);
    } else {
        $('#contact-setting-phone').parent().removeClass('has-error');
        $('#contact-setting-phone').next().hide();
        $('.contact-setting-btn-save').attr('disabled', false);
        var ret = true;
    }


    return ret;

}

function checkPHONECODEField() {
    rePHONE = /^([0-9\+\-\(\) )])+$/;
    var test = rePHONE.test($('#contact-setting-code').val());
    if (!test || $('#contact-setting-code').val() == '') {
        $('#contact-setting-code').next().html('Укажите корректный код страны/города').show();
        $('#contact-setting-code').parent().addClass('has-error');
        $('.contact-setting-btn-save').attr('disabled', true);
        var ret = false;
        //console.log(test);
    } else {
        $('#contact-setting-code').parent().removeClass('has-error');
        $('#contact-setting-code').next().hide();
        $('.contact-setting-btn-save').attr('disabled', false);
        var ret = true;
    }


    return ret;

}


function checkRequiredField(el) {
    var msg = 'Это поле не может быть пустым';
    var s = el.val().replace(/^\s+|\s+$/g, '');

    if (s.length < 3) s = '';

    if (!s) {
        switch (el.attr('id')) {
            case"contact-setting-code":
                msg = 'Укажите корректный код страны/города';
                break;
            case"contact-setting-phone":
                msg = 'Укажите корректный номер телефона';
                break;

            case"contact-setting-text":
            case"contact-setting-title":
            case"contact-setting-subtext":
            case"contact-setting-subtitle":
                msg = 'Пожалуйста, заполните поле <b>' + el.parent().find('label').text() + '</b>, введите более 3 символов';
                break;

        }

        el.next().html(msg).show();

        el.parent().addClass('has-error');
        $('.contact-setting-btn-save').attr('disabled', true);
        var ret = false;
    } else {
        el.parent().removeClass('has-error');
        el.next().hide();
        $('.contact-setting-btn-save').attr('disabled', false);
        var ret = true;
    }


    return ret;
}

