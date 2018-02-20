'use strict';

var _createClass = function() {
    function defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
            var descriptor = props[i];
            descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ("value" in descriptor) descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
        }
    }
    return function(Constructor, protoProps, staticProps) {
        if (protoProps) defineProperties(Constructor.prototype, protoProps);
        if (staticProps) defineProperties(Constructor, staticProps);
        return Constructor;
    };
}();

function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
        throw new TypeError("Cannot call a class as a function");
    }
}

//
// Tabs
//---------------------------------------------------------------------------------------
if ($('.js-tabs').length) {
    var $tabs = $('.js-tabs-item');
    var $panes = $('.js-tabs-content');

    $tabs.on('click', function(event) {
        event.preventDefault();

        var id = $(event.currentTarget).attr('href');

        $tabs.removeClass('is--active');
        $(event.currentTarget).addClass('is--active');

        $panes.removeClass('is--active');
        $(id).addClass('is--active');
    });
}

function showOnHover(element, selectors) {
    $(element).hover(function() {
        $(this).find(selectors).stop().slideDown(300);
    }, function() {
        $(this).find(selectors).stop().slideUp(300);
    });
}

function checkQtyStatus($el, minValue) {
    if (parseInt($el.val(), 10) > minValue) {
        $el.parent().addClass('is--active');
    } else {
        $el.parent().removeClass('is--active');
    }
}

function changeQty($el) {
    var className = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
    var minValue = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1;

    $el.each(function(i, element) {
        var $qty = $(element);
        var $minus = $qty.find('.js-' + className + 'qty-minus');
        var $plus = $qty.find('.js-' + className + 'qty-plus');
        var $input = $qty.find('.js-' + className + 'qty-value');
        var qtyVal = parseInt($input.val(), 10);

        $minus.on('click', function() {
            if (qtyVal > minValue) {
                $input.val(--qtyVal);
            }
            checkQtyStatus($input, minValue);
        });
        $plus.on('click', function() {
            $input.val(++qtyVal);
            checkQtyStatus($input, minValue);
        });
    });
}

changeQty($('.js-qty'));
changeQty($('.js-additive-qty'), 'additive-', 0);

var $productSinglePhoto = $('.product-single__photo');

if ($productSinglePhoto.length) {
    $productSinglePhoto.find('[rel="gallery"]').fancybox();
}

//
// Material Effect for form elements
//---------------------------------------------------------------------------------------
(function() {
    var $inputs = $('.form__input');

    if ($inputs.length) {
        $inputs.each(function(index, element) {
            if ($(element).val() !== '') {
                $(element).parent().find('label').addClass('is--active');
            }
        });

        $inputs.focus(function(event) {
            var $element = $(event.currentTarget);

            $element.parent().find('label').addClass('is--active');
        }).blur(function() {
            var $element = $(event.currentTarget);

            if ($element.val() === '') {
                $element.parent().find('label').removeClass('is--active');
            }
        });
    }
})();

var $el = $('.contact-info__icon');

if ($el.length) {
    $el.on('click', function(event) {
        event.preventDefault();
        $(event.currentTarget).parent().toggleClass('is--active');
    });
}

//
// Slider - on main page
// =================================================================
if ($('.js-slider').length) {
    $('.js-slider').slick({
        arrows: false,
        adaptiveHeight: true,
        infinite: true,
        speed: 400,
        slidesToShow: 1,
        slidesToScroll: 1
    });
}

//
// CLASS - Mobile Menu
// =================================================================

var Menu = function() {
    function Menu() {
        var _this = this;

        _classCallCheck(this, Menu);

        this.closeMobileMenuOnOutOfClick();
        $('.js-nav-toggle').on('click', function() {
            _this.toggleMenuVisibility();
            _this.toggleMenuTriggerClass();
            _this.toggleBodyBackground();
        });
    }
    /* eslint class-methods-use-this: ["error", {
     "exceptMethods": [
     "toggleMenuVisibility",
     "toggleBodyBackground",
     "toggleMenuTriggerClass",
     "closeMobileMenuOnOutOfClick",
     ] }]
     */

    _createClass(Menu, [{
        key: 'toggleMenuVisibility',
        value: function toggleMenuVisibility() {
            $('.mobile-nav').toggleClass('is--visible');
        }
    }, {
        key: 'toggleBodyBackground',
        value: function toggleBodyBackground() {
            $('body').toggleClass('is--mobile-active');
        }
    }, {
        key: 'toggleMenuTriggerClass',
        value: function toggleMenuTriggerClass() {
            $('.js-nav-toggle').toggleClass('is--active');
        }
    }, {
        key: 'closeMobileMenuOnOutOfClick',
        value: function closeMobileMenuOnOutOfClick() {
            var _this2 = this;

            $('body').mouseup(function(e) {
                var subject = $('.is--visible');

                if (subject.length && !$(e.target).hasClass('js-nav-toggle') && !$(e.target).hasClass('icon-nav') && e.target.className !== subject.attr('class') && !subject.has(e.target).length) {
                    _this2.toggleMenuVisibility();
                    _this2.toggleBodyBackground();
                    _this2.toggleMenuTriggerClass();
                }
            });
        }
    }]);

    return Menu;
}();

function initMenu() {
    return new Menu();
}
initMenu();

//
// Modal Popup
// =================================================================
$.arcticmodal('setDefault', {
    afterClose: function afterClose() {
        $('body').css({
            'overflow': 'auto',
            'margin-right': '0px'
        });
    }
});

$('[data-modal]').on('click', function(e) {
    e.preventDefault();
    var link = $(e.currentTarget).data('modal');

    if (link) {
        $('#' + link).arcticmodal();
    }
});

//
// Подключаем fancybox для фото товара
//---------------------------------------------------------------------------------------
var $gallery = $('[rel="gallery"]');

if ($gallery.length) {
    $gallery.fancybox({
        openEffect: 'elastic',
        closeEffect: 'elastic',
        helpers: {
            title: {
                type: 'inside'
            }
        }
    });
}