$(function () {

    var fish = [
        "Далеко-далеко",
        "Да, за словесными горами",
        "Да, в стране гласных и согласных",
        "Да, живут рыбные тексты",
    ];

    $("#fieldName").autocomplete({
        minLength: 1,
        source: fish,
    });

    $('.filter-open').click(function(){
        var brandFilter = $('.brand-filter');
        if(brandFilter.hasClass('active')) {
            brandFilter.removeClass('active');
            setTimeout(function(){
                brandFilter.slideUp(300);
            }, 300);
            $('.filter-open').removeClass('active');
        }
        else {
            brandFilter.slideDown(200);
            setTimeout(function(){
                brandFilter.addClass('active');
                $('body, html').animate({
                    scrollTop: brandFilter.position().top + "px"
                }, 400);
            }, 50);
            $('.filter-open').addClass('active');
        }
        return false;
    });

    $('.hide-filter').click(function () {
        var brandFilter = $('.brand-filter');
        brandFilter.removeClass('active').slideUp(500);
        $('.filter-open').removeClass('active');
    });

    // чекбоксы с категориями
    $('.brand-category .list .item :checkbox').change(function () {
        var _this = $(this),
            parent = _this.closest('.item'),
            id = parent.data('id'),
            list = _this.closest('.list'),
            ul = list.find('ul[data-id=' + id + ']'),
            check = _this.prop('checked') === true ? true : false;
        // если чекнут, показываем подкатегории, чекаем дочерние
        if (check === true) {
            ul.find(':checkbox').prop('checked', true).trigger('refresh');
            list.find('.item').removeClass('active');
            list.find('.sub-list > ul').not(ul).removeClass('open');
            parent.add('active');
            ul.addClass('open');
        }
        // если не чекнут, снимаем чеки с дочерних
        else {
            ul.find(':checkbox').prop('checked', false).trigger('refresh');
        }
    });

    // чекбоксы с подкатегориями
    $('.brand-category .sub-list :checkbox').change(function () {
        var _this = $(this),
            list = _this.closest('ul'),
            id = list.data('id'),
            parentItem = _this.closest('.list').find('.item[data-id=' + id + ']');
        // если хотя бы один чекнутый дочерний есть, чекаем родительскую
        if (list.find(':checked').length >= 1) {
            parentItem.find(':checkbox').prop('checked', true).trigger('refresh');
        }
        // если нет, снимаем чек с родителя
        else {
            parentItem.find(':checkbox').prop('checked', false).trigger('refresh');
        }
    });

    // раскрывашка с подкатегориями
    $('.brand-category .item.has-sub-list').click(function () {
        var _this = $(this),
            id = _this.data('id'),
            list = _this.closest('.list'),
            //subList = _this.nextAll('.sub-list').eq(0);
            ul = list.find('ul[data-id=' + id + ']'),
            top = _this.position().top + _this.outerHeight(),
            open = ul.hasClass('open') === true ? true : false;

        list.find('.item').removeClass('active');
        ul.closest('.sub-list').css({'top': top});
        list.find('.sub-list > ul').not(ul).removeClass('open');

        _this.add('active');

        if (open === true) {
            ul.removeClass('open');
            _this.removeClass('active');
        }
        else {
            ul.addClass('open');
            _this.addClass('active');
        }
    });

    var //checkOneBrand = true,
        //noCheckBrand = false,
        listBrands = $('.check-brands-list'),
        filterParam = $('.filter-param');

    // проверяем кол-во чекнутых брендов
    // если ничего не чекнуто - скрываем выборку по категориям
    // если 1 чекнут - показываем многоуровневую выборку (.filter-param__many)
    // если более 1 чекнуто - показываем выборку по одному (.filter-param__one)
    function amountBrandsCheck() {
        if (listBrands.find(':checked').length > 1) {
            //checkOneBrand = false;
            //noCheckBrand = false;
            filterParam.addClass('active');
            $('.filter-param__one').addClass('active');
            $('.filter-param__many').removeClass('active');
        }
        else if (listBrands.find(':checked').length === 0) {
            noCheckBrand = true;
            filterParam.removeClass('active');
            $('.filter-param__many').removeClass('active');
            $('.filter-param__one').removeClass('active');
        }
        else {
            checkOneBrand = true;
            noCheckBrand = false;
            filterParam.addClass('active');
            $('.filter-param__one').removeClass('active');
            $('.filter-param__many').addClass('active');
        }
    }

    $('.check-brands-list li :checkbox').change(function () {
        amountBrandsCheck();
    });

    // выбираем все, очищаем все
    $('.check-all-or-clear').click(function () {
        var _this = $(this),
            list = $('.' + _this.data('list'));
        if (_this.hasClass('check')) {
            list.find('input:checkbox').not(':disabled').prop('checked', true).trigger('refresh');
        }
        if (_this.hasClass('clear')) {
            list.find('input:checkbox').not(':disabled').prop('checked', false).trigger('refresh');
        }
        amountBrandsCheck();
    });

    $('.brand-category .sub-list').append('<span class="close-sub-list"><i class="icon-close"></i></span>');
    $('.brand-category .sub-list').on('click', '.close-sub-list', function () {
        $(this).closest('.sub-list').find('ul').removeClass('open');
        $(this).closest('.list').find('.item').removeClass('active');
        return false;
    });

});
 


