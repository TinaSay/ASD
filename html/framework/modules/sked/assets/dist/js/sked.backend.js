$(document).ready(function () {


    $('#tabular').on('beforeDeleteRow', function (e, row) {
        if (confirm('Удалить?') == false) return false;
        var id = $(row).find('.file-id').data('id');
        if (typeof id !== 'undefined') {
            $.ajax({
                    'url': '/cp/sked/manage/item-delete',
                    'method': 'GET',
                    'data': {
                        'id': id
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