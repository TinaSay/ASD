$(document).ready(function () {
    if ($('#promoblock-btnshow').val() == "0") {
        $('#promoblock-btntext').hide().parent().hide();
    }

    $('#promoblock-btnshow').on('change', function () {
        switch ($(this).val()) {
            case"0":
                $('#promoblock-btntext').val('').hide().parent().hide();
                break;
            case"1":
                $('#promoblock-btntext').val('Узнать больше').show().parent().show();
                break;
            default:
                $('#promoblock-btntext').val('').hide().parent().hide();
                break;
        }
    });


}); // document.ready

