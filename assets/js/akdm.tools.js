window.akdm = window.akdm || {};

akdm.tools = (function () {
    var public = {};
    
    public.db2LocaleDateStr = function (dateString) {
        try {
            return $.datepicker.formatDate(akdm.config.localeDateFormat,
                $.datepicker.parseDate($.datepicker.ATOM, dateString));
        } catch (e) {
            return null;
        }
    };
    
    public.locale2dbDateStr = function (dateString) {
        try
        {
            return $.datepicker.formatDate($.datepicker.ATOM,
                $.datepicker.parseDate(akdm.config.localeDateFormat, dateString));
        } catch (e) {
            return null;
        }
    };
    
    return public;
})();