define(['jquery', 'lodash', 'app/view-model/bulk-messages',
        'text!views/manager/sms-partial.html', 'text!views/manager/bulk-filter-template.html',
        'k/kendo.binder.min'],
function ($, _, BulkMessagesViewModel, view, filterTemplate, kendo) {
    'use strict';
    
    // TODO: Internacionalizar mensajes
    
    var vmMessage = kendo.observable($.extend(BulkMessagesViewModel(), {
        _MESSAGE_TYPE: 'sms',
        _FILTERABLE_DATA_URL: '/api/sms/contact',
        _SEND_SERVICE_URL: '/api/sms',
        _STRINGS: {
            COMPLETE_MESSAGE_FIRST: 'Complete la lista de destinatarios y el mensaje.'
        },
        _messageIsReadyToBeSent: function () {
            return this.to.length > 0 && this.message;
        },
        getMessage: function () {
            return {
                id: this.id,
                to: this.to,
                subject: this.message && this.message.substr(0, 50),
                message: this.message
            };
        },
        getServiceMessage: function () {
            return {
                to: _.flatten(_.pluck(this.to.toJSON(), 'phone')),
                message: this.message
            };
        },
        updateBtnSend: function (e) {
            if (!_.contains(['to', 'message'], e.field)) return;

            var enable = this.get('to').length > 0 && this.message;
            this.$toolbar.enable('#btnSend', enable);
        },
        messageLength: function () {
            var message = this.get('message');
            return message ? message.length : 0;
        },
        onMessageKeyUp: function (e) {
            this.set('message', e.target.value);
        },
        lengthTipClass: function () {
            var length = this.messageLength();
            return length > 150 ? 'text-danger' : length > 140 ? 'text-warning' : '';
        }
    }));
    
    return {
        show: function (app) {
            var vm;
            window.vm = vm = app.showView('smsPartial', view + filterTemplate, vmMessage).model;
            vm.init(app).load();
        }
    };
});