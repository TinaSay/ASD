jQuery(function ($) {
    $('.rate-form').submit(
        function () {

            var url = $('.rate-form').attr('action');
            var rating = $('input.get_rate').val();
            var module = $('input.get_module').val();
            var record_id = $('input.get_record_id').val();
            var title = $('input.get_title').val();

            $.ajax({
                type: "POST",
                url: url,
                data: {title: title, module: module, record_id: record_id, rating: rating},
                success: function (result) {
                    if (result.status == 'ok') {
                        $('.rate_row').empty();
                        $('.rate_row').starwarsjs({
                            target: '.rate_row',
                            stars: 5,
                            default_stars: result.rating
                        });
                    }
                },
                error:
                    function (jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText);
                    }
            });
            $('.rate-form').addClass('send');
            return false;
        }
    );
});