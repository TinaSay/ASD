$(document).ready(function () {
    var tpl = '';
    var counter = 1;
    $('.field-division-metro').hide();
    jQuery('#division-metrocomplete').autocomplete(
        {
            'source': "/cp/ru-RU/contact/division/get-metro-list",
            'minLength': 2,
            'select': function (event, ui) {
                tpl = '<fieldset class="bg-orange-metro">';
                tpl += '<div class="form-group field-division-metro-log" >';
                tpl += '<label class="control-label">Название станции</label>';
                tpl += '<input type="text" class="form-control" name="Metro[' + counter + '][name]" value="' + ui.item.value + '" style="width: 200px;" readonly="readonly">';
                tpl += '<div class="help-block"></div>';
                tpl += '</div>';
                tpl += '<div class="form-group field-division-metro-log" >';
                tpl += '<label class="control-label" >Расстояние</label>';
                tpl += '<input type="text" class="form-control" name="Metro[' + counter + '][distance]" style="width: 100px;">';
                tpl += '<div class="help-block"></div>';
                tpl += '</div>';
                tpl += '<div class="form-group field-division-metro-log" >';
                tpl += '<label class="control-label" >Цвет</label>';
                tpl += '<input type="text" class="form-control" name="Metro[' + counter + '][color]" style="width: 100px;" onkeyup="MetroCheckColor(this);">';
                tpl += '<div class="help-block"></div>';
                tpl += '</div>';
                tpl += '<div class="form-group field-division-metro-log" >';
                tpl += '<button type="button" class="btn btn-warning" onclick="jQuery(this).parent().parent().remove();">Удалить</button>';
                tpl += '</div>';
                tpl += '</fieldset>';
                $('#metro-holder').append(tpl);
                setTimeout(function () {
                    jQuery('#division-metrocomplete').val('');
                }, 10);
                counter++;

            }
        });

    $('.add-requisite-field').on('click', function () {
        tpl = '<div class="container field-division-requisite-widget">';
        tpl += '<div class="row">';
        tpl += '<div class="col-sm-6" >';
        tpl += '<input type="text" class="form-control" name="Requisite[name][]" placeholder="Название файла"  >';
        tpl += '<input type="hidden" name="Division[requisite]" value=""><input type="file" id="division-requisite" name="Requisite[src][]" >';
        tpl += '</div>';
        tpl += '<div class="col-sm-4" >';
        tpl += '<button type="button" class="btn btn-warning" onclick="$(this).parent().parent().parent().remove();">';
        tpl += '<span class="glyphicon glyphicon-trash"></span>';
        tpl += '</button>';
        tpl += '</div>';
        tpl += '</div>';
        tpl += '</div>';
        $('#requisite-holder').append(tpl);
        counter++;
    });


    var $request2;
    $("#division-adres-metrocomplete").on('keyup', function (e) {

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
            url: 'https://geocode-maps.yandex.ru/1.x/?geocode=' + $(this).val(),
            data: {'kind': 'street', 'format': 'json', 'results': '10'},
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
                                            $el.data('id', $(this).data('id'));
                                            $el.data('lat', $(this).data('lat'));
                                            $el.data('lng', $(this).data('lng'));
                                            // set value of hidden input
                                            $('#' + $el.data('dictionary') + "_id").val($el.data('id'));
                                            // set parent id of next autocomplete input
                                            if (typeof $el.data('next') != 'undefined') {
                                                $('#' + $el.data('next')).data('parent_id', $el.data('id'));
                                            }
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
                            // set value of hidden input
                            $el.val($(this).data('value'));
                            $('#division-lat').val($(this).data('lat'));
                            $('#division-long').val($(this).data('lng'));
                            $el.parent().removeClass('open');
                        });
                    }
                    var UL = $el.next('.dropdown-menu');

                    for (var i in ymapsdata) {
                        //if (ymapsdata[i].GeoObject.metaDataProperty.GeocoderMetaData.kind == 'street') {
                        var item = ymapsdata[i].GeoObject;
                        item.lat = item.Point.pos.split(' ')[0];
                        item.lng = item.Point.pos.split(' ')[1];
                        UL.append('<li><a href="#"  data-id="' + '0' + '"' +
                            (item.lat ? 'data-lat="' + item.lat + '" ' : '') +
                            (item.lng ? 'data-lng="' + item.lng + '" ' : '') +
                            ' data-value="' + item.metaDataProperty.GeocoderMetaData.text + '">'
                            + item.metaDataProperty.GeocoderMetaData.text + '</a></li>');
                        //}
                    }


                    // $el.blur();
                    // UL.focus();
                    $el.parent().addClass('open');
                } else {
                    $el.parent().removeClass('open');
                }

            }
        });//ajax ends
    }).on('blur', function () {
        setTimeout(function () {
            $("#division-adres-metrocomplete").parent().removeClass('open');
        }, 100);

    });

    $('#tabular').on('beforeDeleteRow', function (e, row) {
        if (confirm('Удалить?') == false) return false;
        var id = $(row).find('.requisite-file-id').data('id');
        if (typeof id !== 'undefined') {
            $.ajax('/cp/contact/division/requisite-delete', {
                    'method': 'POST',
                    'data': {
                        'requisite_id': id
                    },
                    'success': function (res) {
                        if (res != false) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            );
        }

    });


}); // document.ready

function metroDelete(id) {
    if (confirm('Удалить?')) {
        $.ajax('/cp/contact/division/metro-delete', {
                'method': 'POST',
                'data': {
                    'metro_id': id
                },
                'success': function (res) {
                    if (res != false) {
                        $('#metro-update-' + id).remove();
                    }
                }
            }
        );
    }
}

function MetroCheckColor(el) {
    $item = $(el);
    var value = $item.val().replace(/\s/gi, '');
    re = /^[abcdef0-9]+$/i;
    var test = re.test(value);
    if (!test || value.length < 6 || value.length > 6) {
        $item.css('color', 'red');
        return false;
    } else {
        $item.css('color', '#3b4256');
        return true;
    }
}

function requisiteDelete(id) {
    if (confirm('Удалить?')) {
        $.ajax('/cp/contact/division/requisite-delete', {
                'method': 'POST',
                'data': {
                    'requisite_id': id
                },
                'success': function (res) {
                    if (res != false) {
                        $('#requisite-update-' + id).remove();
                    }
                }
            }
        );
    }
}
