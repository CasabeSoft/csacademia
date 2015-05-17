define(['jquery', 'k/kendo.ui.core.min', 'jquery.easing', 'bootstrap'], 
function ($, kendo) {
    var vmHome = kendo.observable({
        isRegistering: false,
        data: {
            schoolPlans: [],
            teacherPlans: [],
            features: []
        },
        contact: {
            name: null,
            email: null,
            phone: null,
            message: null
        },
        contactFeedback: {
            type: 'error',
            text: null
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
        },
        onPhoneChange: function (e) {
            var $email = $('#contact input[type=email]');
            if (this.get('contact.phone')) {
               $email.removeAttr('required');
            } else {
               $email.attr('required', 'required');
            }
        },
        onContactSubmit: function (e) {
            var _this = this;
            e.preventDefault();
            kendo.ui.progress($('#contact form'), true);
            $.post('/contact',
                this.contact.toJSON(),
                function (result) {
                    console.log(result);
                    if (result) {
                        _this.set('contactFeedback.type', 'success');
                        _this.set('contactFeedback.text', 'Gracias... hemos recibido tus datos');
                    }
                }
            ).
            fail(function (error) {
                console.log(error);
                _this.set('contactFeedback.type', 'error');
                _this.set('contactFeedback.text', 
                    'Algo ha ido mal... y no hemos podido guardar sus datos. Por favor, escríbanos directamente a contacto@casabesoft.com');
            }).
            always(function () {
                kendo.ui.progress($('#contact form'), false);
                setTimeout(function () {
                    _this.set('contactFeedback.text', null);
                }, 5000);
            });
            return false;
        },
        contactFeedbackClass: function () {
            return "alert alert-dismissible " +
                    (this.get('contactFeedback.type') === 'success' ?
                        'alert-success' :
                                'alert-danger');
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