define(['jquery', 'app/view-model/bulk-messages',
        'text!views/manager/email-partial.html', 'text!views/manager/bulk-filter-template.html',
        'k/kendo.binder.min'],
function ($, BulkMessagesViewModel, view, filterTemplate, kendo) {
    'use strict';
    
    var vmMessage = kendo.observable(BulkMessagesViewModel());
    
    return {
        show: function (app) {
            var vm;
            window.vm = vm = app.showView('emailPartial', view + filterTemplate, vmMessage).model;
            vm.init(app).load();
        }
    };
});