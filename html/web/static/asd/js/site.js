function goBack() {
    window.history.back();
}

$(document).ready(function () {

    $('.brand-xs-more').click(function(){
        var parent = $(this).closest('.brand-xs__box'),
            toggle = parent.find('.brand-xs-toggle'),
            open = parent.hasClass('open');
        $('.brand-xs-toggle').slideUp(300);
        $('.brand-xs__box').removeClass('open');
        if(open){
            toggle.slideUp(300);
            parent.removeClass('open');
        }
        else {
            toggle.slideDown(300);
            parent.addClass('open');
        }
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('[data-toggle="tab"]').on('show.bs.tab', function (e) {
        var href = $(this).attr('href');
        if($('li a[href="'+href+'"]').length > 1){
            $('li a[href="'+href+'"]').closest('ul').find('li').removeClass('active');
            $('li a[href="'+href+'"]').parent('li').addClass('active');
        }
    });

    $('[data-toggle="tab"]').on('hide.bs.tab', function (e) {
        var href = $(this).attr('href');
        if($('li a[href="'+href+'"]').length > 1){
            $('li a[href="'+href+'"]').parent('li').removeClass('active');
        }
    });

    $('.select-val').focus(function () {
        $(this).select();
    });

    $('.name-tooltip').hover(function () {
        var _this = $(this),
            widthPar = _this.outerWidth(),
            widthChild = _this.find('> span').outerWidth();
        if (widthPar < widthChild) {
            $(this).addClass('hover');
        }
    }, function () {
        $(this).removeClass('hover');
    }, 100);

    if ($('.block-aside-left-fix').length > 0) {

        function make_sticky() {
            $("[data-sticky_aside]").stick_in_parent({
                parent: '[data-sticky_parent]',
                offset_top: 0
            });
        }

        make_sticky();
    }

});

$(window).on('load', function () {
    setTimeout(function () {
        $('.promo-slide-picture').slick('slickGoTo', 0);
        $('.promo-slide').slick('slickGoTo', 0);
    }, 0);

    setTimeout(function () {
        $('.load').fadeOut(300);
    }, 200);

    // скрываем лоадер
    setTimeout(function () {
        $('body').removeClass('anim-load');
    }, 0);
    $('.promo-slide-picture').slick('slickPlay');
    $('.promo-slide').slick('slickPlay');
    $('.promo-slide-picture').slick('slickGoTo', 1);
    $('.promo-slide').slick('slickGoTo', 1);
});

(function ($) {
    // переводы фенсибокс
    $('[data-fancybox]').fancybox({
        lang: 'ru',
        i18n: {
            'ru': {
                CLOSE: 'Закрыть',
                NEXT: 'Назад',
                PREV: 'Вперёд',
                ERROR: 'Не удалось установить соединение. <br/> Пожалуйста, попробуйте позднее.',
                PLAY_START: 'Начать слайдшоу',
                PLAY_STOP: 'Поставить на паузу',
                FULL_SCREEN: 'На полный экран',
                THUMBS: 'Превью'
            }
        }
    });

    $(".section-hit .tab-content").swipe({
        swipeRight: function (event, direction) {
            var tab = $(this).closest('.section-hit').find('.mobile-hit-nav').find('.active').prev(),
                nav = $(this).closest('.section-hit').find('.mobile-hit-nav'),
                pos;
            if (tab.length > 0) {
                pos = tab.find('a').position().left + nav.scrollLeft();
                tab.find('a').tab('show');
                nav.scrollLeft(pos - 100);
            }
        },
        swipeLeft: function (event, direction) {
            var tab = $(this).closest('.section-hit').find('.mobile-hit-nav').find('.active').next(),
                nav = $(this).closest('.section-hit').find('.mobile-hit-nav'),
                pos;
            if (tab.length > 0) {
                pos = tab.find('a').position().left + nav.scrollLeft();
                tab.find('a').tab('show');
                nav.scrollLeft(pos - 100);
            }
        }
    });

    $('.mobile-hit-nav a').click(function () {
        var _this = $(this),
            parent = _this.closest('.mobile-hit-nav'),
            pos = _this.position().left + parent.scrollLeft();
        parent.scrollLeft(pos - 100);
    });

    $('.promo-slide-picture').slick({
        slidesToShow: 1,
        autoplay: false,
        autoplaySpeed: 4000,
        speed: 500,
        slidesToScroll: 1,
        fade: true,
        asNavFor: '.promo-slide',
        dots: false,
        arrows: false,
    });

    $('.promo-slide').slick({
        slidesToShow: 1,
        autoplay: false,
        speed: 500,
        autoplaySpeed: 4000,
        fade: true,
        slidesToScroll: 1,
        asNavFor: '.promo-slide-picture',
        arrows: false,
        dots: true,
        appendDots: '.promo-slide__dots'
    });

    var $body = $('body'),
        bottomPanel = $('.add-nav-xs');

    if ($('.scroll').length > 0) {
        $('.scroll').each(function () {
            var ps = new PerfectScrollbar($(this)[0]);
        });
    }


    // видео
    var currentVideo = false;

    $('.close-page-layer').click(function () {
        if (currentVideo != false) {
            currentVideo.pause();
            setTimeout(function () {
                currentVideo.currentTime = 0;
                currentVideo = false;
            }, 700);
        }
    });

    $('.video-play').click(function () {
        var videoId = $(this).data('video'),
            video = document.getElementById(videoId);
        video.play();
        currentVideo = video;
    });

    $body.on("click", "video", function () {
        if (this.paused) {
            this.play();
        }
        else {
            this.pause();
        }
    });
    // end видео


    // slider-catalogue-big
    $('.slider-catalogue-big').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        infinite: true,
        fade: true,
        asNavFor: '.slider-catalogue-nav'
    });

    var centerSlide = true;

    $('.slider-catalogue-nav').on('init', function (event, slick) {
        var lengthSlide = $(this).find('.item').length;
        if (lengthSlide < 5) {
            centerSlide = false;
        }
    });

    $('.slider-catalogue-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slider-catalogue-big',
        dots: false,
        centerPadding: '0px',
        infinite: true,
        centerMode: true,
        variableWidth: true,
        focusOnSelect: true,
        nextArrow: '.slider-catalogue-nav__next',
        prevArrow: '.slider-catalogue-nav__prev',
        responsive: [
            {
                breakpoint: 1500,
                settings: {
                    slidesToShow: 4
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1
                }
            },
        ]
    });

    if (centerSlide === false) {
        $('.slider-catalogue-nav').slick("slickSetOption", "centerMode", false);
        $('.slider-catalogue-nav').addClass('no-center-slide');
    }


    // fix для ширины выпадашки
    jQuery.ui.autocomplete.prototype._resizeMenu = function () {
        var ul = this.menu.element;
        ul.outerWidth(this.element.outerWidth());
    }


    // в блоке .only-one-check можно выбрать только один чекбокс
    $('.only-one-check :checkbox').change(function () {
        var _this = $(this),
            parent = _this.closest('.only-one-check');
        if (_this.prop('checked') === true) {
            parent.find(':checkbox').not(_this).prop('checked', false).trigger('refresh');
        }
    });


    // очищалка в поле
    $('.field-with-clear').each(function () {
        var _this = $(this),
            count = _this.find('input:text').val().length;
        _this.append('<i class="clear"></i>');
        if (count > 0) {
            _this.addClass('active');
        }
        else {
            _this.removeClass('active');
        }
    });
    $('.field-with-clear input:text').on('input', function () {
        var _this = $(this),
            count = _this.val().length;
        if (count > 0) {
            _this.closest('.field-with-clear').addClass('active');
        }
        else {
            _this.closest('.field-with-clear').removeClass('active');
        }
    });
    $('.field-with-clear').on('click', '.clear', function () {
        var _this = $(this),
            parent = _this.closest('.field-with-clear'),
            input = parent.find('input:text');
        input.val('');
        parent.removeClass('active');
    });


    // fix panel footer
    if ('ontouchstart' in window) {
        $(document).on('focus', 'textarea, input, select', function () {
            bottomPanel.css('margin-bottom', '-700px');
        }).on('blur', 'textarea, input, select', function () {
            bottomPanel.css('margin-bottom', '0');
        });
    }

    $('.field-clear').click(function () {
        $(this).closest('.form-groupe').find('input.form-control').val('');
        return false;
    });

    $('input[type=checkbox], input[type=radio], select').styler();

    if (device.desktop() === true) {
        // появление контента анимация
        new cbpScroller(document.getElementById('cbp-so-scroller'));
    }

    $('.check-confirm').change(function () {
        var check = $(this).prop('checked');
        if (check == true) {
            $(this).closest('.btn-and-info').find('.btn-confirm').prop('disabled', false);
            return false;
        }
        else {
            $(this).closest('.btn-and-info').find('.btn-confirm').prop('disabled', true);
            return false;
        }
    });

    $('.aside__sub-layer-close').click(function () {
        $('.aside__sub-layer').removeClass('active');
        $('.aside__nav a').removeClass('active');
    });

    $('.history-slide').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        asNavFor: '.history-slide-year ul',
        nextArrow: '.history-slide__nav .next',
        prevArrow: '.history-slide__nav .prev',
        fade: true,
        dots: false,
        arrows: true,
        infinite: false,
        adaptiveHeight: true,
    }).on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        $('.history-inner-slider').slick('slickGoTo', 0);
    });

    $('.history-inner-slider').slick({
        slidesToShow: 1,
        autoplay: true,
        speed: 500,
        autoplaySpeed: 3500,
        fade: true,
        slidesToScroll: 1,
        arrows: false,
        dots: true,
    });

    $('.history-slide-year ul').slick({
        slidesToShow: 13,
        slidesToScroll: 1,
        asNavFor: '.history-slide',
        focusOnSelect: true,
        fade: false,
        dots: false,
        arrows: false,
        adaptiveHeigh: true,
        infinite: false,
        responsive: [
            {
                breakpoint: 1000,
                settings: {
                    slidesToShow: 8
                }
            },
            {
                breakpoint: 560,
                settings: {
                    slidesToShow: 5
                }
            }
        ]
    });

    $('.offer-amount-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 2000,
    });


    var winWidth = $(window).width();


    $(document).ready(function () {
        if ($(window).width() <= 670) {
            $('.slide-mobile').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: false,
                dots: true,
                arrows: false
            });
        }
    });

    $(window).on('load resize orientationChange', function (event) {
        if ($(window).width() !== winWidth) {
            winWidth = $(window).width();
            setTimeout(function () {
                if ($(window).width() > 670) {
                    $('.slide-mobile').each(function () {
                        $(this).slick('unslick');
                    });
                }
                else {
                    $('.slide-mobile').each(function () {
                        $(this).slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            fade: false,
                            dots: true,
                            arrows: false,
                        });
                    });
                }
            }, 200);
        }
    });

    $('.show-search-field').click(function () {
        if ($(window).width() >= 1250) {
            return true;
        }
        var parent = $(this).closest('.footer-header__search');
        if (!(parent.hasClass('active'))) {
            $(this).closest('.footer-header__search').addClass('active');
            return false;
        }
    });

    // поиск в шапке
    $(document).on('focus', '.header .form-group--search .form-control', function () {
        $(this).closest('form').addClass('active');
    }).on('blur', '.header .form-group--search .form-control', function () {
        $(this).closest('form').removeClass('active');
    });

    $('.hide-search-field').click(function () {
        $(this).closest('.footer-header__search').removeClass('active');
        $(this).prop('disabled', 'true');
    });

    $('.form-search-sliding-close').click(function () {
        $('.form-search-sliding__wrap').removeClass('active');
    });

    function asideSubLayer(elem) {
        $('.aside__sub-layer').addClass('active');
        $('.aside__sub-nav-item').hide();
        $('.aside__nav a').removeClass('active');
        elem.addClass('active');
        $('.aside__sub-nav-item#' + elem.data('nav')).show();
        $('.page-layer.open').addClass('overlay');
    }

    $('.page-layer, .pd-aside, .aside__head').on('mouseover', function () {
        setTimeout(function () {
            $('.page-layer.open').removeClass('overlay');
        }, 20);
    });

    $('.aside__nav a[data-nav]').on('mouseover click', function () {
        asideSubLayer($(this));
        return false;
    });

    $('.btn-aside-push').click(function () {
        $('.aside__sub-layer').removeClass('active');
        $('.aside__nav a').removeClass('active');
    });

    $('.aside__sub-layer').mouseleave(function(){
        if($(window).width() > 767) {
            setTimeout(function(){
                if($('.aside__nav').is(':hover') === false) {
                    $('.aside__nav a').removeClass('active');
                    $('.aside__sub-layer').removeClass('active');
                }
            }, 20)
        }
        return false;
    });

    $('.pd-aside, .aside__head').mouseover(function () {
        if ($(window).width() > 767) {
            setTimeout(function () {
                $('.aside__nav a').removeClass('active');
                $('.aside__sub-layer').removeClass('active');
            }, 20)
        }
        return false;
    });

    $('.brand-list li').click(function () {
        var $this = $(this),
            id = $('.brand-list li').index($this);
        $('.brand-list li').removeClass('active');
        $(this).addClass('active');
        $('.brand-slide__item').removeClass('active');
        $('.brand-slide__item').eq(id).addClass('active');
        return false;
    });

    // прячем элементы навигации при ресайзе
    function navComponent() {
        var _this = this;

        // задаем контейнеру объектов ширину
        this.setContainerWidth = function (container, containerParent, containerNeighbour, navElemString, navContainerString) {
            container.each(function () {
                var elem = this,
                    elemWidth;
                if (containerNeighbour.outerWidth() > containerParent.outerWidth() / 2) {
                    containerParent.addClass('nav-two-column');
                    elemWidth =
                        containerParent.outerWidth();
                    container.css({
                        'width': '100%',
                    });
                }
                else {
                    elemWidth =
                        containerParent.outerWidth() -
                        containerNeighbour.outerWidth() - 50;
                    container.css({
                        'width': elemWidth + 40 + 'px',
                    });
                }
            });

            _this.adaptNav(container, navElemString, navContainerString);
        };


        // высчитываем общую ширину всех блоков внутри контейнера
        this.adaptNav = function (container, navElemString, navContainerString) {
            container.each(function () {
                var elem = $(this),
                    navElem = container.find(navElemString),
                    navContainer = container.find(navContainerString),
                    compareCounter = 1,
                    allNavElemWidth = 0;

                for (var i = 0; i < navElem.length; i++) {
                    allNavElemWidth += navElem.eq(i).outerWidth() +
                        parseInt(navElem.eq(i).css('margin-left')) +
                        parseInt(navElem.eq(i).css('margin-right'));

                    if (elem.outerWidth() < allNavElemWidth + 50) {
                        compareCounter++;
                    }


                }

                _this.compareContainerElemWidth(
                    container,
                    navElemString,
                    allNavElemWidth,
                    navContainer,
                    compareCounter);
            });
        };


        // прячем лишние блоки в несколько итераций.
        this.compareContainerElemWidth = function (container, navElemString, elemWidth, navContainer, counts) {
            navContainer.find('> ' + navElemString).insertBefore(navContainer.parent());

            for (var i = 1; i < counts; i++) {
                container.find('> ' + navElemString).eq(-1).prependTo(navContainer);
            }
        };


        // по клику на ссылку вытаскиваем её из родителя и закидываем после ссылки "все"
        this.showActiveElem = function (container, navElemString, elem) {
            var allElem = container.find(">" + navElemString).eq(0);

            elem.insertAfter(allElem);
        };


        // инициализируем все эти операции
        this.init = function (container, containerParent, containerNeighbour, navElemString, navContainerString) {
            _this.setContainerWidth(container, containerParent, containerNeighbour, navElemString, navContainerString);
        };
    }


    var navComponentVar = new navComponent();

    function checkTabsContainer() {
        $('.tabs-container').each(function () {
            var elem = $(this),
                containerElems = elem.find('.custom-tab-item');

            if (containerElems.length != 0) {
                elem.addClass('container-active');
            } else {
                elem.removeClass('container-active');
            }
        });
    }

    var navComponentTimeout;

    function initNavComponent() {
        $('.nav-tabs').each(function () {
            navComponentVar
                .init(
                    $(this),
                    $(this).parents('.tabs-nav-wrap'),
                    $(this).parents('.tabs-nav-wrap').find('.section-head').eq(0),
                    '.custom-tab-item',
                    '.tabs-container__content');
        });
        checkTabsContainer();
    }

    $(window).on('load', function () {
        initNavComponent();
    });
    $(window).on('resize', function () {
        setTimeout(function () {
            initNavComponent();
        }, 300);
    });

})(jQuery);

$(document).ready(function () {

    var $body = $('body');
    $('.open-page-layer').click(function () {
        var $this = $(this),
            page = $this.data('href');

        // при повторном клике на ссылку на слой, слой закрываем
        if($('.page-layer[id="'+page+'"]').hasClass('open')){
            $('.page-layer[id="'+page+'"]').find('.close-page-layer').click();
            return false;
        }

        if ($body.hasClass('page-layer-open')) {
            $('.page-layer.open').each(function () {
                var prev = $(this),
                    zPrev = prev.css('z-index');
                prev.css('z-index', zPrev - 1)
                    .addClass('prev')
                    .attr('data-prev', zPrev - 1);
            });
            if ($('.page-layer[id="' + page + '"].open.prev').length > 0) {
                $('.page-layer[id="' + page + '"]').css('z-index', 1550).removeClass('prev');
                return false;
            }
        }
        $body.addClass('page-layer-open');
        $('.page-layer[id="' + page + '"]').addClass('open').removeClass('prev');
        $('.site-overlay').fadeIn(400);
        $('.aside__nav a').removeClass('active');
        $('.aside__sub-layer').removeClass('active');
        return false;
    });

    $('.close-page-layer, .site-overlay, .close-layer').click(function () {
        var _this = $(this);

        function authStart() {
            $('.tab-auth').hide().removeClass('active');
            $('.tab-auth[data-tab="auth-form"]').show().addClass('active');
        }

        function closeAllLayers() {
            $body.removeClass('page-layer-open');
            if (!($body.hasClass('pushy-open-left'))) {
                $('.site-overlay').fadeOut(700);
            }
            else {

            }
            $('.page-layer').css('z-index', 1550);
            $('.page-layer').removeClass('open');
            authStart();
        }

        if (_this.hasClass('.site-overlay')) {
            closeAllLayers();
            return false;
        }
        if ($('.page-layer.open').length > 1) {
            _this.closest('.page-layer').removeClass('open');
            $('.page-layer').removeClass('prev');
            if (_this.closest('.page-auth').length > 0) {
                authStart();
            }
        }
        else {
            closeAllLayers();
        }
        return false;
    });

    $(document).mouseup(function (e) {
        var container = $(".page-layer.open").not('prev');
        if (container.has(e.target).length === 0 && $('.aside').has(e.target).length === 0 && $('.add-nav-xs').has(e.target).length === 0 && $('.ui-timepicker').has(e.target).length === 0) {
            $(".page-layer.open").not('.prev').removeClass('open');
            $(".page-layer[data-prev='1549']").removeClass('prev').css('z-index', 1550);
        }
    });

    $('.tab-auth-link').click(function () {
        var _this = $(this),
            tab = _this.data('toggle');
        $('.tab-auth').hide().removeClass('active');
        $('.tab-auth[data-tab="' + tab + '"]').show().addClass('active');
        return false;
    });

    // Javascript to enable link to tab
    var hash = document.location.hash;
    var prefix = "tab_";
    if (hash) {
        $('.nav-tabs a[href="' + hash.replace(prefix, "") + '"]').tab('show');
    }

    // Change hash for page-reload
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash.replace("#", "#" + prefix);
    });

    $('#page-cooperation').find('.page-layer__inner').html(''); // task 34004


    // смена рекордов
    $('.more-banners').click(function (e) {
        e.preventDefault();
        var $parent = $(this).closest('.container'),
            $visibleBlock = $parent.find('.records-list:visible'),
            $recordsWrap = $visibleBlock.find('.records-list__wrap'),
            $showBlock;

        $recordsWrap.css({'min-height': $visibleBlock.outerHeight()});

        if ($visibleBlock.next('.records-list').length) {
            $showBlock = $visibleBlock.next('.records-list');
        } else {
            $showBlock = $parent.find('.records-list:first');
        }
        $visibleBlock.addClass('anim-hidden');
        setTimeout(function ($visibleBlock, $showBlock) {
            $visibleBlock.addClass('hidden');
            $showBlock.removeClass('hidden').addClass('anim-visible animated fadeInUp')
        }, 200, $visibleBlock, $showBlock);
    });
});




