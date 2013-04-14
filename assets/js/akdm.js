window.akdm = window.akdm || {};

akdm.setConfig = function (config) {
    akdm.config = akdm.config || {};
    $.extend(akdm.config, config);
};
