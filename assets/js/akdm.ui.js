window.akdm = window.akdm || {};

akdm.ui = (function () {
    var public = {};
    
    public.initHelpers = function () {
        // Inicialización de componentes UI
    };

    var _feedbackTemplate = '<div class="alert feedback fade in"><a class="close" data-dismiss="alert" href="#">&times;</a><div class="feedbackContent">{message}</div></div>';
    
    public.Feedback = {
        SHORT: 3000,
        LONG: 6000,
        ALERT: '',
        ERROR: 'alert-error',
        SUCCESS: 'alert-success',
        INFO: 'alert-info',
        show : function (selector, message, type, autoClose) {
            var fdbk = $(_feedbackTemplate.replace('{message}', message));
            fdbk.addClass(type);
            fdbk.appendTo(selector);
            if (autoClose)
                setTimeout(function () {
                    fdbk.alert('close');
                }, autoClose);
        }
    };
    
    return public;
})();