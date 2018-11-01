function rateAdvice() {

    var url = $('.rate-form').attr('action');
    var rating = $('input.get_rate').val();
    var module = $('input.get_module').val();
    var record_id = $('input.get_record_id').val();
    var title = $('input.get_title').val();
    var rateForm = $('.rate-form');
    var rateRow = $('.rate_row');
    var rateDisabled = true;

    $.ajax({
        type: "POST",
        url: url,
        data: {title: title, module: module, record_id: record_id, rating: rating},
        success: function (result) {
            if (result.status == 'ok') {
                $('.rate_row').empty();
                $('.rate_row').starwarsjs({
                    target: '.rate_row',
                    stars: 10,
                    default_stars: rating,
                    disable: 0
                });
                //$('div.rate_num > .num').text(result.rating);
                $('div.rate_num > .num').text(rating);
                $('.rate-form__caption').text('Ваша оценка');
                rateForm.removeClass('change');

                // при наведении отображаем в цифрах кол-во звезд
                rateForm.on('mouseover', '.rate_star', function(){
                  if(rateDisabled) { 
                    return false; 
                  }
                  $('.rate_num .num').html($('.rate_star.over').length);
                });
                rateRow.on('mouseout', '.rate_star', function(){
                  if(rateDisabled) { 
                    return false; 
                  }
                  $('.rate_num .num').html(0);
                });

            }
        },
        error:
            function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
    });

}

