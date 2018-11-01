$('.custom-tab-item a').on('click', function () {
    $('.custom-tab-item').removeClass('active');
    $(this).parent().addClass('active');

    var type = $(this).data('type');
    var term = $('#searchform-page-term').val();
    var url = $('#navbar-hit').data('url');
    var page = $('#navbar-hit').data('page');
    var per_page = $('#navbar-hit').data('per-page');

    $.ajax({
        url: url,
        dataType: 'html',
        type: 'get',
        data: {'term': term, 'type': type, 'page': page, 'per-page': per_page},
        success: function (data) {
            $('.search_result').html(data).show();
        },
    });

    return false;
});
