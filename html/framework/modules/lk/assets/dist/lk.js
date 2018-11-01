$form = $('.form-filter'),
    (function ($) {


        var fish = [
            "Далеко-далеко",
            "Да, за словесными горами",
            "Да, в стране гласных и согласных",
            "Да, живут рыбные тексты",
        ];

        $("#fieldName").autocomplete({
            minLength: 1,
            source: fish,
        });

        $("#fieldBrand").autocomplete({
            minLength: 1,
            source: fish,
        });

        $('.parent-layer').autocomplete({
            appendTo: '.page-goods .page-layer__inner'
        });

        var goodsParam = $('#goodsParam');

        $('#goodsParamOpen').click(function () {
            goodsParam.toggleClass('active').slideToggle(200);
            $(this).toggleClass('active');
        });


        $('#docDateTo').Zebra_DatePicker({
            view: 'years',
            direction: false,
            pair: $('#docDateFrom'),
            open_icon_only: true,
            readonly_element: false,
            format: "d.m.Y",
            onSelect: function (view, elements) {
                $form.trigger('submit');
            }
        });

        $('#docDateFrom').Zebra_DatePicker({
            view: 'years',
            direction: 1,
            open_icon_only: true,
            readonly_element: false,
            format: "d.m.Y",
            onSelect: function (view, elements) {
                $form.trigger('submit');
            }
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
                $("input#minCost").val($("#slider").slider("values", 0)).trigger('change');
                $("input#maxCost").val($("#slider").slider("values", 1)).trigger('change');

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
        $('#slider input').keypress(function (event) {
            var key, keyChar;
            if (!event) var event = window.event;

            if (event.keyCode) key = event.keyCode;
            else if (event.which) key = event.which;

            if (key == null || key == 0 || key == 8 || key == 13 || key == 9 || key == 46 || key == 37 || key == 39) return true;
            keyChar = String.fromCharCode(key);

            if (!/\d/.test(keyChar)) return false;

        });

        // доки открываем
        $('.white-block #order-table').on('click', '.show-lk-doc.exists-doc', function () {
            var _this = $(this);
            if(!$(this).hasClass('active')) {
                var id = $(this).closest('.li-inner').attr('id');
                var wrap = $('.lk-doc[data-id="' + id + '"] .lk-doc__list');
                wrap.load('/lk/default/get-order-document' + '?' + 'id=' + id, function () {
                    _this.toggleClass('active');
                    _this.closest('li, .li').find('.lk-doc').slideToggle();
                });
            } else {
                _this.toggleClass('active');
                _this.closest('li, .li').find('.lk-doc').slideToggle();
            }
        });


        // при клике на удалить, выводим сообщеньку
        $(".delete-confirm").not('.no-active').on('click', function () {
            var _this = $(this),
                text = _this.data('text');

            $.fancybox.open({
                type: 'html',
                baseClass: 'fc-confirm',
                src:
                '<div class="fc-content">' +
                '<h5 class="title">' + text + '</h5>' +
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

        $('#ordersearch-status').on('change', function () {
            $('.form-filter').trigger('submit');
        });
        $('#docDateTo').on('change', function () {
            $('.form-filter').trigger('submit');
        });
        $('#docDateFrom').on('change', function () {
            $('.form-filter').trigger('submit');
        });
        $('#minCost').on('change', function () {
            $('.form-filter').trigger('submit');
        });
        $('#maxCost').on('change', function () {
            $('.form-filter').trigger('submit');
        });

        $('#order-table').on('click', '.sort-col', function(e) {
            e.preventDefault();
            var wrap = $(this).closest('#order-table');
            wrap.load($(this).attr('href'), function () {

            });
            return false;
        });

        $('.form-filter').on('submit', function (e) {
            e.preventDefault();
            //$.pjax.reload({container:'#order-table'});
            var wrap = $('#order-table');
            wrap.load($form.attr('action') + '?' + $form.serialize(), function () {

            });
            return false;
        });

        $('#order-table').on('click', '.pagination a', function (e) {
            e.preventDefault();
            var wrap = $(this).closest('#order-table');
            wrap.load($(this).attr('href'), function () {

            });


        });
    })(jQuery);
