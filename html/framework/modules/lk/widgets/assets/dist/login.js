$(document).ready(function () {
    $('#formAuth').on('beforeSubmit', function () {
        $('#enter-lk').prop('disabled', true);
        $('.row-spinner').show();
        var $yiiform = $(this);
        $.ajax({
                type: $yiiform.attr('method'),
                url: $yiiform.attr('action'),
                data: $yiiform.serializeArray()
            }
        ).done(function (data) {
            $('#enter-lk').prop('disabled', false);
            $('.row-spinner').hide();
            $('#formAuth input').parent().removeClass('error');
            $('#formAuth input').parent().find('.error').remove();
            if (data.success) {
                // data is saved
            } else if (data.validation) {
                // server validation failed
                $.each(data.validation, function (key, val) {
                    if ($('#formAuth').find('#' + key)) {
                        if ($('#' + key).val() != '') {
                            $('#' + key).parent().addClass('full');
                        }
                        $('#' + key).parent().addClass('error');
                        $('#' + key).parent().append('<label class="error">' + val[0] + '</label>');
                    }
                });
                console.log(data.validation);
            } else {
                // incorrect server response
            }
        }).fail(function () {
            // request failed
        });

        return false; // prevent default form submission
    });
});