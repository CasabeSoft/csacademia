define(['jquery', 'k/kendo.ui.core.min', 'jquery.easing', 'bootstrap'], 
function ($, kendo) {
    var vmHome = kendo.observable({
        isRegistering: false,
        data: {
            schoolPlans: [],
            teacherPlans: [],
            features: []
        },
        status: function () {
            return this.get('isRegistering') ? 'registering' : '';
        },
        startRegistering: function () {
            var _this = this;
            var moveToTop;
            if (!this.isRegistering) {
                moveToTop = $('.call-4-action').css('top') !== '0px';
                if (moveToTop) {
                    $('.call-4-action').css({
                        'top': '20px',
                        transform: 'translateY(0)', 
                        '-webkit-transform': 'translateY(0)',
                        '-moz-transform': 'translateY(0)',
                        '-ms-transform': 'translateY(0)'});
                }
                setTimeout(function () {
                    kendo.fx($("#register fieldset")).expand("vertical").stop().play();
                    $('#register input:first').focus();
                }, moveToTop ? 1050 : 0);
                this.set('isRegistering', true);
                return false;
            }
        },
        startRole: function () {
            return this.get('isRegistering') ? 'submit' : 'button';
        },
        showLogin: function () {
            kendo.fx($(".login")).expand("vertical").stop().play();
        },
        hideLogin: function () {
            $('#lnkLogin').popover('hide');
            return false;
        }
    });
    window.vmHome = vmHome;

    function init() {
        $.getJSON('/assets/js/data/home.json', function (result) {
            vmHome.set('data', result);
        });
        $('a.cs-scroll-to').bind('click', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
        $('#lnkLogin').popover({
            html: true,
            content: $('#loginTemplate').html()
        }).on('shown.bs.popover', function () {
            kendo.bind('.login', vmHome);
        });
        kendo.bind('.cs-home', vmHome);
    }
    
    init();
});