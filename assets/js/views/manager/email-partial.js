define(['jquery', 'lodash', 'app/view-model/filter-data',
        'text!views/manager/email-partial.html', 'text!views/manager/bulk-filter-template.html', 
        'k/kendo.binder.min', 'k/kendo.editor.min', 'k/kendo.toolbar.min', 
        'k/kendo.multiselect.min', 'k/kendo.notification.min', 'k/kendo.dropdownlist.min'],
function ($, _, Filter, view, filterTemplate, kendo) {
    'use strict';
    
    // TODO: Internacionalizar mensajes
    
    var EMAIL_DRAFT,
        EMAIL_TEMPLATES,
        $popup,
        $toolbar;
    
    function initToolbar () {
        $toolbar = $('#toolbar').kendoToolBar({
            items: [
                { type: 'button', text: 'Enviar', id: 'btnSendEmail', 
                    enable: false, click: vmEmail.send.bind(vmEmail) },
                { type: 'button', text: 'Añadir seleccionados', icon: 'plus', click: vmEmail.addTo.bind(vmEmail) },
                {
                    type: 'splitButton',
                    text: 'Guardar',
                    icon: 'tick',
                    click: vmEmail.save.bind(vmEmail),
                    menuButtons: [
                        { text: 'Guardar como borrador', icon: 'tick', click: vmEmail.save.bind(vmEmail) },
                        { text: 'Guardar como plantilla', icon: 'restore', click: vmEmail.saveAsTemplate.bind(vmEmail) }
                    ]
                },
                {
                    template: '<input id="ddlTemplates" />',
                    overflow: 'never'
                },
                { type: 'button', text: 'Descartar', icon: 'cancel', click: vmEmail.discard.bind(vmEmail) },
                { type: 'button', text: 'Eliminar', icon: 'close', click: vmEmail.remove.bind(vmEmail) }
            ]            
        }).data('kendoToolBar');
    }
    
    var vmEmail = kendo.observable({
        filter: new Filter(),
        id: _.uniqueId(),
        to: [],
        subject: null,
        message: null,
        templates: new kendo.data.DataSource({ data: [] }),
        _messageIsReadyToBeSent: function () {
            return this.to.length > 0 && this.subject && this.message;
        },
        init: function () {
            var _this = this;
            if (this._inited) return this;
            
            this.filter.config().loadData();
            
            initToolbar();
            $popup = $('<span></span>').kendoNotification({position: {top: 50 }, stacking: 'down'}).data('kendoNotification');
            $('#ddlTemplates').kendoDropDownList({
                optionLabel: 'Plantilla',
                dataSource: this.templates,
                dataValueField: 'uid',
                dataTextField: 'subject',
                change: this.loadTemplate
            });
            this.bind('change', function (e) {
                if (_.contains(['to', 'subject'], e.field))
                    _this.updateBtnSendEmail();
            });
            
            this._inited = true;
            return this;
        },
        _loadEmail: function (email) {
            email = email || JSON.parse(localStorage.getItem(EMAIL_DRAFT) || null);
            if (email) {
                this.set('id', email.id);
                this.set('to', email.to || []);
                this.set('subject', email.subject);
                this.set('message', email.message);
            } else {
                this._restart();
            }
        },
        _loadTemplates: function (templates) {
            templates = templates || JSON.parse(localStorage.getItem(EMAIL_TEMPLATES) || '{}');
            this.templates.data(_.sortBy(_.values(templates), 'subject'));
        },
        load: function () {
            this._loadEmail();
            this._loadTemplates();
            return this;
        },
        loadTemplate: function (e) {
            var _this = e.sender.dataSource.parent();
            _this._loadEmail(e.sender.dataItem());
        },
        addTo: function () {
            var _this = this;
            _.each(this.filter.filterableData.view(), function (data) {
                if (data.selected) _this.to.push(data);
            });
            this.filter.set('checkAll', false);
            this.filter.toogleCheckAll();
        },
        removeFromTo: function (e) {
            this.to.remove(e.data);
        },
        send: function () {
            var _this = this;
            if (!this._messageIsReadyToBeSent()) {
                $popup.show('Complete la lista de destinatarios, el asunto y el mensaje.', 'warning');
                return;
            }
            $.post('/api/email', 
                {
                    to: _.flatten(_.pluck(this.to.toJSON(), 'email')),
                    subject: this.subject,
                    message: this.message
                }
            ).done(function (result) {
                console.log(result);
                if (result) {
                    $popup.show('Mensaje eviado satisfactoriamente', 'info');
                    localStorage.removeItem(EMAIL_DRAFT);
                    _this._restart();
                } else {
                    $popup.show('Algo ha fallado, enviando el mensaje.', 'warning');
                }
            }).fail(function (error) {
                console.log(error);
                $popup.show('Ha ocurrido un error enviando el mensaje.', 'error');
            });
        },
        save: function () {
            var email = {
                id: this.id,
                to: this.to,
                subject: this.subject,
                message: this.message
            };
            localStorage.setItem(EMAIL_DRAFT, JSON.stringify(email));
            return email;
        },
        saveAsTemplate: function () {
            var templates = JSON.parse(localStorage.getItem(EMAIL_TEMPLATES) || '{}');
            templates[this.id] = this.save();
            localStorage.setItem(EMAIL_TEMPLATES, JSON.stringify(templates));
            this.templates.data(_.sortBy(_.values(templates), 'subject'));
        },
        _restart: function () {
            this.set('id', _.uniqueId());
            this.set('to', []);
            this.set('subject', null);
            this.set('message', null);
        },
        discard: function () {
            if (confirm('¿Quiere descartar el mensaje actual?')) {
                this._restart();
            }
        },
        remove: function () {
            if (confirm('¿Quiere eliminar el mensaje actual y su plantilla asociada?')) {
                var templates = JSON.parse(localStorage.getItem(EMAIL_TEMPLATES) || '{}');
                delete templates[this.id];
                localStorage.removeItem(EMAIL_DRAFT);
                localStorage.setItem(EMAIL_TEMPLATES, JSON.stringify(templates));
                this._restart();
                this._loadTemplates();
            }
        },
        updateBtnSendEmail: function () {
            var enable = this.get('to').length > 0 && this.get('subject');
            $toolbar.enable('#btnSendEmail', enable);
        }
    });
    
    return {
        show: function (app) {
            var vm;
            EMAIL_DRAFT = 'client_' + app.config.client_id + '.bulk_operations.email.draft';
            EMAIL_TEMPLATES = 'client_' + app.config.client_id + '.bulk_operations.email.templates';
            window.vm = vm = app.showView('emailPartial', view + filterTemplate, vmEmail).model;
            vm.init().load();
        }
    };
});