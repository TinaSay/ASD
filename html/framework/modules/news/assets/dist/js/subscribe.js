$(document).ready(function () {

    $('.field-feedback-msg_type').hide();

    $('.unsubscribe-btn').click(function () {
        document.location.href = $(this).attr('rel');
    });


}); // document.ready


