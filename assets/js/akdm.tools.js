window.akdm = window.akdm || {};

akdm.tools = (function () {
    var public = {};
    
    public.db2LocaleDateStr = function (dateString) {
        return $.datepicker.formatDate(akdm.config.localeDateFormat,
            $.datepicker.parseDate($.datepicker.ATOM, dateString));
    };
    
    public.locale2dbDateStr = function (dateString) {
        return $.datepicker.formatDate($.datepicker.ATOM,
            $.datepicker.parseDate(akdm.config.localeDateFormat, dateString));
    };
    
    return public;
})();