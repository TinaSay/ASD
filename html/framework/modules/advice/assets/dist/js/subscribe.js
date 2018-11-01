$(document).ready(function () {

    var ptrn = /advice/;
    if (!ptrn.test(document.location.href)) {

        // определяем страну пользователя и записываем в куки
        $.ajax({
            url: 'http://freegeoip.net/json/', // country request
            type: 'get',
            dataType: 'json'
        }).done(function (data) {
            console.log('Вы находитесь в стране ' + data.country_name);
            if (data.country_name) {
                window.utils.Cookie.set('country_en', data.country_name); // ENGLISH
                // API yandex translate
                var key = 'trnsl.1.1.20171027T095233Z.b20bc091bce6611d.d93a94431c5550db16997745347c140841b7dbdb';
                var trurl = 'https://translate.yandex.net/api/v1.5/tr.json/translate?' +
                    'key=' + key + '&text=' + data.country_name + '&lang=en-ru';
                $.ajax({
                    url: trurl,
                    type: 'get',
                    dataType: 'json'
                }).done(function (cc) {
                    window.utils.Cookie.set('country_ru', cc.text); // RUSSIAN
                });

            }
        });
    }


}); // document.ready


function checkEMAILField() {
    $emailfld = $('input[name="mail"]');
    reEmail = /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/;
    var test = reEmail.test($emailfld.val());
    if (!test) {
        $emailfld.parent().addClass('has-error');
        $('.form-group--field-btn > .btn-primary').attr('disabled', true);
        var ret = false;
    } else {
        $emailfld.parent().removeClass('has-error');
        $('.form-group--field-btn > .btn-primary').attr('disabled', false);
        var ret = true;
    }
    return ret;
}
