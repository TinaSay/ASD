$(function () {

    var $form = $('#catalog-filter-form');
    $('input.autocomplete').each(function (index, elem) {
        var $this = $(elem),
            $hiddenInput = $('<input type="hidden" name="' + $this.attr('name') + '"/>');

        if ($this.data('source')) {
            $this.attr('name', '');
            $hiddenInput.insertAfter($this);
            $this.autocomplete({
                minLength: $this.data('min') ? $this.data('min') : 1,

                select: function (event, ui) {
                    $this.val(ui.item.label);
                    $hiddenInput.val(ui.item.id);
                }
            });
        }
    });

    var $fieldName = $("#fieldName");
    $fieldName.autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.getJSON($fieldName.data('source'), {term: request.term, "_": (new Date()).getTime()}, function (data) {
                response(data.list);
            })
        },
        select: function (event, ui) {
            if (ui.item.url) {
                document.location.href = ui.item.url;
            }
        }
    });

    $('.filter-open').click(function () {
        var brandFilter = $('.brand-filter');
        if (brandFilter.hasClass('active')) {
            brandFilter.removeClass('active');
            setTimeout(function () {
                brandFilter.slideUp(300);
            }, 300);
            $('.filter-open').removeClass('active');
        }
        else {
            brandFilter.slideDown(200);
            setTimeout(function () {
                brandFilter.addClass('active');
                $('body, html').animate({
                    scrollTop: brandFilter.position().top + "px"
                }, 400);
            }, 50);
            $('.filter-open').addClass('active');
        }
        return false;
    });

    $('.hide-filter').click(function () {
        var brandFilter = $('.brand-filter');
        brandFilter.removeClass('active').slideUp(500);
        $('.filter-open').removeClass('active');
    });

    reInitSectionCheckbox();

    // выбираем все, очищаем все
    $('.check-all-or-clear').click(function () {
        var _this = $(this),
            list = $('.' + _this.data('list'));
        if (_this.hasClass('check')) {
            list.find('input:checkbox').not(':disabled').prop('checked', true)
                .trigger('refresh').trigger('change');
        }
        if (_this.hasClass('clear')) {
            list.find('input:checkbox').not(':disabled').prop('checked', false)
                .trigger('refresh').trigger('change');
        }
    });

    function reInitSectionCheckbox() {
        // чекбоксы с категориями
        $('.brand-category .list .item :checkbox').change(function () {
            var _this = $(this),
                parent = _this.closest('.item'),
                id = parent.data('id'),
                list = _this.closest('.list'),
                ul = list.find('ul[data-id=' + id + ']'),
                check = _this.prop('checked') === true;
            // если чекнут, показываем подкатегории, чекаем дочерние
            if (check === true) {
                ul.find(':checkbox').prop('checked', true).trigger('refresh');
                list.find('.item').removeClass('active');
                list.find('.sub-list > ul').not(ul).removeClass('open');
                parent.add('active');
                ul.addClass('open');
            }
            // если не чекнут, снимаем чеки с дочерних
            else {
                ul.find(':checkbox').prop('checked', false).trigger('refresh');
            }
        });

        // чекбоксы с подкатегориями
        $('.brand-category .sub-list :checkbox').change(function () {
            var _this = $(this),
                list = _this.closest('ul'),
                id = list.data('id'),
                parentItem = _this.closest('.list').find('.item[data-id=' + id + ']');
            // если хотя бы один чекнутый дочерний есть, чекаем родительскую
            if (list.find(':checked').length >= 1) {
                parentItem.find(':checkbox').prop('checked', true).trigger('refresh');
            }
            // если нет, снимаем чек с родителя
            else {
                parentItem.find(':checkbox').prop('checked', false).trigger('refresh');
            }
        });

        // раскрывашка с подкатегориями
        $('.brand-category .item.has-sub-list').click(function () {
            var _this = $(this),
                id = _this.data('id'),
                list = _this.closest('.list'),
                //subList = _this.nextAll('.sub-list').eq(0);
                ul = list.find('ul[data-id=' + id + ']'),
                top = _this.position().top + _this.outerHeight(),
                open = ul.hasClass('open') === true;

            list.find('.item').removeClass('active');
            ul.closest('.sub-list').css({'top': top});
            list.find('.sub-list > ul').not(ul).removeClass('open');

            _this.add('active');

            if (open === true) {
                ul.removeClass('open');
                _this.removeClass('active');
            }
            else {
                ul.addClass('open');
                _this.addClass('active');
            }
        });

        $('.brand-category .sub-list').append('<span class="close-sub-list"><i class="icon-close"></i></span>')
            .on('click', '.close-sub-list', function () {
                $(this).closest('.sub-list').find('ul').removeClass('open');
                $(this).closest('.list').find('.item').removeClass('active');
                return false;
            });

        $('.brand-category input').styler();
    }

    // dynamic detect brands for client category
    $('.client-category-item').on('change', function () {
        var $this = $(this),
            $list = $this.closest('.check-who-list').find('input:checked'),
            $childContainer = $($this.data('control'));
        if ($list.data('loading') === true) {
            return false;
        }
        countGoods();
        if ($childContainer.length) {
            if ($list.length) {
                $list.data('loading', true);
                var data = {'ids': [], '_csrf': $('meta[name=csrf-token]').attr('content')};
                $list.each(function (index, elem) {
                    data.ids.push($(elem).data('id'));
                });
                $.ajax({
                    url: $this.data('url'),
                    dataType: 'JSON',
                    type: 'POST',
                    data: data,
                    success: function (data) {
                        $list.data('loading', false);
                        if (data.success) {
                            $childContainer.find('input')
                                .prop('disabled', true);
                            for (var j in data.list) {
                                if (data.list.hasOwnProperty(j)) {
                                    $childContainer.find('input[data-id="' + data.list[j] + '"]')
                                        .prop('disabled', false);
                                }
                            }
                            $childContainer.find('input:disabled').prop('checked', false);
                            setTimeout(function () {
                                $childContainer.find('input').trigger('refresh');
                                if($childContainer.find('input').not(':disabled').length < 1) {
                                    $('.filter-brands .param-btn').addClass('disabled');
                                }
                                else {
                                    $('.filter-brands .param-btn').removeClass('disabled');
                                }
                            }, 50);
                        }
                    }
                });
            } else {
                $childContainer.find('input')
                    .prop('disabled', true);
                $('.filter-brands .param-btn').addClass('disabled');
                setTimeout(function () {
                    $childContainer.find('input').trigger('refresh');
                }, 50);
            }
        }
    }).triggerHandler('change');

    var filterParam = $('.filter-param'),
        filterParamOne = filterParam.find('.filter-param__many'),
        filterParamMany = filterParam.find('.filter-param__one');

    // show sections for brand
    $('.brand-item').on('change', function () {
        var $this = $(this),
            $list = $this.closest('.check-brands-list').find('input:checked'),
            url;

        if ($form.data('loading') !== true) {
            countGoods();
        }
        // hide params
        if ($list.length < 1) {
            filterParam.hide();
            filterParamOne.find('input').prop('disabled', true);
            filterParamMany.find('input').prop('disabled', true);
            // show usages
        } else if ($list.length === 1) {
            if ($list.data('loading') === true) {
                return false;
            }
            $list.data('loading', true);
            filterParamMany.removeClass('active');
            $this = $list.eq(0);
            if ($this.data('section-id') === '') {
                filterParam.hide();
            }
            if (filterParamOne.data('loading') === true || $this.data('section-id') === '') {
                return false;
            }
            url = filterParamOne.data('url') + '?id=' + $this.data('id');
            filterParamOne.load(url, function (response) {
                $list.data('loading', false);
                if (response > '') {
                    filterParam.show();
                    filterParamMany.removeClass('active')
                        .find('input')
                        .prop('disabled', true);

                    reInitSectionCheckbox();

                    filterParamOne.addClass('active');
                } else {
                    filterParam.hide();
                }
            });

        } else {
            if ($list.data('loading') === true) {
                return false;
            }
            $list.data('loading', true);
            filterParamOne.removeClass('active')
                .find('input')
                .prop('disabled', true);
            var data = {'ids': [], '_csrf': $('meta[name=csrf-token]').attr('content')};
            $list.each(function (index, elem) {
                data.ids.push($(elem).data('id'));
            });
            $.ajax({
                url: filterParamMany.data('url'),
                dataType: 'JSON',
                type: 'POST',
                data: data,
                success: function (data) {
                    $list.data('loading', false);
                    if (data.success) {
                        filterParam.show();
                        filterParamMany.find('input')
                            .prop('disabled', true);
                        for (var j in data.list) {
                            if (data.list.hasOwnProperty(j)) {
                                filterParamMany.find('input[data-id="' + data.list[j] + '"]')
                                    .prop('disabled', false);
                            }
                        }
                        filterParamMany.find('input:disabled').prop('checked', false);
                        setTimeout(function () {
                            filterParamMany.find('input').trigger('refresh');
                        }, 50);
                        filterParamMany.addClass('active');
                    }
                }
            });
        }
    }).triggerHandler('change');

    $form.on('change', '.section-item, .usage-item', function () {
        if ($form.data('loading') === true) {
            return false;
        }
        countGoods();
    });

    // count goods by filter
    function countGoods() {
        $form.data('loading', true);
        var url = $form.data('count-url');
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            data: $form.serialize(),
            success: function (data) {
                $form.data('loading', false);
                if (data.success) {
                    if (data.count > 0) {
                        $('.filter-footer .amount').text(data.count);
                        $('.filter-footer .btn').prop('disabled', false);
                    } else {
                        $('.filter-footer .amount').text('');
                        $('.filter-footer .btn').prop('disabled', true);
                    }
                    $('.filter-footer .goods').text(data.text);
                }
            }
        })
    }

});