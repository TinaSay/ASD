var jobs;
$(document).ready(function () {

    $('.by-region-list').hide().parent().hide();

    $('#tabular').on('beforeDeleteRow', function (e, row) {
        if (confirm('Удалить?')) {
            var id = $(row).find('.packetFile-file-id').data('id');
            if (typeof id !== 'undefined') {
                $.ajax('/cp/packet/manage/file-delete', {
                        'method': 'POST',
                        'data': {
                            'fileId': id
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
        }

    });

    $('#packet-category').on('change', function () {
        $('.by-region-list').hide().parent().hide();
        $('#packet-byregion').val(0);
        $('#packet-byregion').selectpicker('refresh');
    });

    if ($('#packet-byregion').val() == "1") {
        $('.by-region-list').show().parent().show();
        updateCountryList();
    }

    $('#packet-byregion').on('change', function () {
        switch ($(this).val()) {
            case"0":
                $('.by-region-list').hide().parent().hide();
                break;
            case "1":
                $('.by-region-list').show().parent().show();
                updateCountryList();
                break;
        }
    });
    $('#packet-country').on('change', function () {
        updateCityList();
    });


    $('.btn-success, .btn-primary').on('click', function (e) {
        var value = $('#packet-city').prev().prev().find('span').text();
        $('#packet-city').remove();
        $('#packet-form-id').find('input[name="Packet[city]"]').val(value);
    });


    $('.action-send-emails').click(function () {
        $(this).text('Подождите...').attr('disabled', true);
        $('.alert-info').remove();
        $('#queue-info').remove();
        $('.card').parent().prepend('<div id="queue-info" class="alert-info alert fade in">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
            '<span id="queue-log">Идет отправка почты....</span></div>');
        //alert($(this).attr('rel'));
        $.ajax({
            'url': $(this).data('send-url'),
            'method': 'GET',
            'dataType': 'json',
            'success': function (data) {
                jobs = data.jobs;
                if (data.success == true) {
                    $('#queue-log').text('Идет отправка почты. В очереди писем ' + jobs.length);
                } else {
                    $('#queue-log').text(data.errors);
                }
                setTimeout(worker, 5000);
            },

        });

    });

    function worker() {
        $.ajax({
            'url': $('.action-send-emails').data('status-url'),
            'method': 'GET',
            'dataType': 'json',
            'success': function (data) {
                if (typeof (data.sent) !== undefined) {
                    var sentMail = declOfNum(data.sent, ['письмо', 'письма', 'писем']);
                    var countMail = declOfNum(data.sent, ['письмо', 'письма', 'писем']);

                    if (data.success == true) {
                        $('#queue-log').text('Идет отправка почты. В очереди ' + data.count + ' ' + countMail + '. Отправлено ' + data.sent + ' ' + sentMail + '.');
                    } else {
                        $('#queue-log').text(data.errors);
                    }
                    if (data.count == 0) {
                        $('#queue-log').text('Рассылка завершена. Отправлено ' + data.sent + ' ' + sentMail + '.');
                        $('.action-send-emails').text('Отправлено');
                    } else {
                        setTimeout(worker, 5000);
                    }
                }
            }
        });
    }

    function declOfNum(n, titles) {
        return titles[(n % 10 === 1 && n % 100 !== 11) ? 0 : n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20) ? 1 : 2]
    }

}); // document.ready

function updateCityList() {

    $('#packet-city').prev().prev().find('span').first().text('Выберите город из списка');
    var country = $('#packet-country').val();
    if (country) {
        $.ajax({
            url: '/cp/packet/manage/city-list', // country request
            type: 'post',
            dataType: 'json',
            data: {
                'country': country,
                'category': $('#packet-category').val(),
                'id': document.location.href.split('/').pop()
            }
        }).done(function (data) {
            $('#packet-city').html('');
            if (data.list.length > 0) {
                for (var i = 0; i < data.list.length; i++) {
                    var item = data.list[i];
                    $('#packet-city').append('<option ' + (item.selected ? 'selected' : '') + ' value="' + item.city + '">' + item.city + '</option>');
                }
            }
            $('#packet-city').selectpicker('refresh');
        });
    }


}

function updateCountryList() {

    $.ajax({
        url: '/cp/packet/manage/country-list', // country request
        type: 'post',
        dataType: 'json',
        data: {
            'category': $('#packet-category').val(),
            'id': document.location.href.split('/').pop()
        }
    }).done(function (data) {
        $('#packet-country').html('');
        $('#packet-city').html('');
        $('#packet-city').selectpicker('refresh');
        if (data.list.length > 0) {
            for (var i = 0; i < data.list.length; i++) {
                var item = data.list[i];
                $('#packet-country').append('<option ' + ' value="' + item.country + '">' + item.country + '</option>');
            }
        }
        $('#packet-country').selectpicker('refresh');
        updateCityList();

    });
}





