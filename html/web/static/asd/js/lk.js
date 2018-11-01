$(document).ready(function () {


    $('#docDateTo').Zebra_DatePicker({
        view: 'years',
        direction: false,
        pair: $('#docDateFrom'),
        open_icon_only: true,
        readonly_element: false,
        format: "d.m.Y",
    });

    $('#docDateFrom').Zebra_DatePicker({
        view: 'years',
        direction: 1,
        open_icon_only: true,
        readonly_element: false,
        format: "d.m.Y",
    });

    $(window).resize(function () {
        $('#docDateTo').Zebra_DatePicker({
            view: 'years',
            direction: false,
            pair: $('#docDateFrom'),
            open_icon_only: true,
            readonly_element: false,
            format: "d.m.Y",
        });
        $('#docDateFrom').Zebra_DatePicker({
            view: 'years',
            direction: 1,
            open_icon_only: true,
            readonly_element: false,
            format: "d.m.Y",
        });
    });


    /* слайдер цен */

    $("#slider").slider({
        min: 0,
        max: 9999999,
        values: [0, 9999999],
        range: true,
        stop: function (event, ui) {
            $("input#minCost").val($("#slider").slider("values", 0));
            $("input#maxCost").val($("#slider").slider("values", 1));

        },
        slide: function (event, ui) {
            $("input#minCost").val($("#slider").slider("values", 0));
            $("input#maxCost").val($("#slider").slider("values", 1));
        }
    });

    $("input#minCost").change(function () {

        var value1 = $("input#minCost").val();
        var value2 = $("input#maxCost").val();

        if (parseInt(value1) > parseInt(value2)) {
            value1 = value2;
            $("input#minCost").val(value1);
        }
        $("#slider").slider("values", 0, value1);
    });


    $("input#maxCost").change(function () {

        var value1 = $("input#minCost").val();
        var value2 = $("input#maxCost").val();

        if (value2 > 9999999) {
            value2 = 9999999;
            $("input#maxCost").val(9999999)
        }

        if (parseInt(value1) > parseInt(value2)) {
            value2 = value1;
            $("input#maxCost").val(value2);
        }
        $("#slider").slider("values", 1, value2);
    });


    // фильтрация ввода в поля
    $('input').keypress(function (event) {
        var key, keyChar;
        if (!event) var event = window.event;

        if (event.keyCode) key = event.keyCode;
        else if (event.which) key = event.which;

        if (key == null || key == 0 || key == 8 || key == 13 || key == 9 || key == 46 || key == 37 || key == 39) return true;
        keyChar = String.fromCharCode(key);

        if (!/\d/.test(keyChar)) return false;

    });

    // доки открываем
    $('.show-lk-doc').not('.no-active').click(function () {
        var _this = $(this);
        _this.toggleClass('active');
        _this.closest('li').find('.lk-doc').slideToggle();
    });


    // при клике на удалить, выводим сообщеньку
    $(".delete-confirm").not('.no-active').click(function () {
        var _this = $(this);

        $.fancybox.open({
            type: 'html',
            baseClass: 'fc-confirm',
            src:
            '<div class="fc-content">' +
            '<h5 class="title">Подтвердите, пожалуйста, удаление позиции.</h5>' +
            '<div class="btn-confirm-wrap">' +
            '<a data-value="1" class="btn btn-primary" data-fancybox-close>Удалить</a>' +
            '<button data-value="0" class="btn btn-default" data-fancybox-close class="btn">Отмена</button>' +
            '</div>' +
            '</div>',
            buttons: [],
            afterClose: function (instance, current, e) {
                var button = e ? e.target || e.currentTarget : null,
                    value = button ? $(button).data('value') : 0,
                    li = _this.closest('li');
                if (value === 1) {
                    setTimeout(function () {
                        li.slideUp(300);
                    }, 300);
                    setTimeout(function () {
                        li.remove();
                    }, 700);
                }
            }
        });

    });

});
