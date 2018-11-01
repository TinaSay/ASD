(function ($) {
    var $metatagSwitcher = $('#metatagSwitcher');

    var metatagSwitcher = localStorage.getItem('metatagSwitcher');
    if (metatagSwitcher === '1') {
        $metatagSwitcher.prop('checked', true);
    } else {
        $metatagSwitcher.prop('checked', false);
    }

    $metatagSwitcher.on('switchChange.bootstrapSwitch', function (e, state) {
        if (state || $(this).is(':checked')) {
            $('.metatags').removeClass('hidden');
            localStorage.setItem('metatagSwitcher', '1');
        } else {
            $('.metatags').addClass('hidden');
            localStorage.setItem('metatagSwitcher', '0');
        }
    }).trigger('switchChange.bootstrapSwitch');

})(jQuery);