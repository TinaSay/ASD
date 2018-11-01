(function ($) {
    var $container = $('.related-products'),
        perPage = isNaN(parseInt($container.data('per-page'))) ? 4 : parseInt($container.data('per-page'));
    $('.related-products .update-link').on('click', function (e) {
        e.preventDefault();
        $container.find('.offer-list__item.hidden')
            .slice(0, perPage)
            .css('display', 'none')
            .removeClass('hidden')
            .fadeIn();
        if ($container.find('.offer-list__item.hidden').length <= 0) {
            $(this).hide();
        }
    });
})(jQuery);