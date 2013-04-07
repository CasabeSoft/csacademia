var akdm = window.akdm || {};

akdm.tools = {
    db2LocaleDateStr: function (dateString) {
        return $.datepicker.formatDate($.datepicker.regional[akdm.config.locale].dateFormat,
            $.datepicker.parseDate($.datepicker.ATOM, dateString));
    },
    locale2dbDateStr: function (dateString) {
        return $.datepicker.formatDate($.datepicker.ATOM,
            $.datepicker.parseDate($.datepicker.regional[akdm.config.locale].dateFormat, dateString));
    }
};