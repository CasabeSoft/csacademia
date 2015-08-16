define(['jquery', 'lodash', 'app/view-model/filter-data',
        'k/kendo.binder.min', 'k/kendo.editor.min', 'k/kendo.toolbar.min', 
        'k/kendo.multiselect.min', 'k/kendo.notification.min', 'k/kendo.dropdownlist.min'],
function ($, _, Filter, kendo) {
    'use strict';
    
    // TODO: Internacionalizar mensajes
    
    var $popup,
        filtersDefinition = [
            {
                name: 'Tipo',
                field: 'type',
                type: 'string',
                values: [
                    {value: 'S', text: 'Alumno'},
                    {value: 'T', text: 'Profesor'},
                    {value: 'C', text: 'Contacto'}
                ]
            },
            {
                name: 'Estado',
                field: 'isActive',
                type: 'boolean',
                values: [
                    {value: true, text: 'Alta'},
                    {value: false, text: 'Baja'}
                ]
            },
            {
                name: 'Género',
                field: 'sex',
                type: 'string',
                values: [
                    {value: 'M', text: 'Masculino'},
                    {value: 'F', text: 'Femenino'}
                ]
            },
            {
                name: 'Grupo',
                field: 'group',
                type: 'number',
                values: [
                ]
            },
            {
                name: 'Mes',
                field: 'month',
                type: 'number',
                values: [
                    {value: 1, text: 'enero'},
                    {value: 2, text: 'febrero'},
                    {value: 3, text: 'marzo'},
                    {value: 4, text: 'abril'},
                    {value: 5, text: 'mayo'},
                    {value: 6, text: 'junio'},
                    {value: 7, text: 'julio'},
                    {value: 8, text: 'agosto'},
                    {value: 9, text: 'septiembre'},
                    {value: 10, text: 'octubre'},
                    {value: 11, text: 'noviembre'},
                    {value: 12, text: 'diciembre'}
                ]
            },
            {
                name: 'Día',
                field: 'day',
                type: 'number',
                values: _.map(_.range(1, 32), function (value) { return { value: value, text: value}; }) 
            }
        ];
        
    var dsGroups = new kendo.data.DataSource({
            transport: {
                read: {
                    url: '/group/get'
                }            
            },
            schema: {
                model: {
                    id: 'value',
                    fields: {
                        value: { from: 'id', type: 'number' },
                        text: 'name'
                    }
                }
            }
        });

    function buildDataDataSource(readUrl) {
        return new kendo.data.DataSource({
            transport: {
                read: {
                    url: readUrl
                }            
            },
            schema: {
                model: {
                    id: 'id',
                    fields: {
                        isActive: {from: 'is_active', type: 'boolean', parse: function (value) { return value === '1'; } },
                        type: 'contact_type',
                        group: {from: 'group_id', type: 'number'},
                        day: {from: 'day', type: 'number'},
                        month: {from: 'month', type: 'number'}
                    }
                }
            },
            sort: { field: 'name', dir: 'asc' },
            requestStart: function () {
                kendo.ui.progress($('#filter'), true);
            },
            requestEnd: function () {
                kendo.ui.progress($('#filter'), false);
            }
        });
    }
    
    function initToolbar (viewModel) {
        viewModel.$toolbar = $('#toolbar').kendoToolBar({
            items: [
                { type: 'button', text: 'Enviar', id: 'btnSend', 
                    enable: false, click: viewModel.send.bind(viewModel) },
                { type: 'button', text: 'Añadir seleccionados', icon: 'plus', click: viewModel.addTo.bind(viewModel) },
                {
                    type: 'splitButton',
                    text: 'Guardar',
                    icon: 'tick',
                    click: viewModel.save.bind(viewModel),
                    menuButtons: [
                        { text: 'Guardar como borrador', icon: 'tick', click: viewModel.save.bind(viewModel) },
                        { text: 'Guardar como plantilla', icon: 'restore', click: viewModel.saveAsTemplate.bind(viewModel) }
                    ]
                },
                {
                    template: '<input id="ddlTemplates" />',
                    overflow: 'never'
                },
                { type: 'button', text: 'Descartar', icon: 'cancel', click: viewModel.discard.bind(viewModel) },
                { type: 'button', text: 'Eliminar', icon: 'close', click: viewModel.remove.bind(viewModel) }
            ]            
        }).data('kendoToolBar');
    }
    
    function BulkMessagesViewModel() {
        return {
            _DRAFT: null,
            _TEMPLATES: null,
            _MESSAGE_TYPE: 'email',
            _FILTERABLE_DATA_URL: '/api/email/contact',
            _SEND_SERVICE_URL: 'api/email',
            _STRINGS: {
                COMPLETE_MESSAGE_FIRST: 'Complete la lista de destinatarios, el asunto y el mensaje.'
            },
            $toolbar: null,
            filter: new Filter(),
            id: _.uniqueId(),
            to: [],
            subject: null,
            message: null,
            templates: new kendo.data.DataSource({ data: [] }),
            _messageIsReadyToBeSent: function () {
                return this.to.length > 0 && this.subject && this.message;
            },
            init: function (app) {
                var _this = this,
                    dsData,
                    resizeTimeout;
                if (this._inited) return this;

                this._DRAFT = 'client_' + app.config.client_id + '.bulk_operations.' + this._MESSAGE_TYPE + '.draft';
                this._TEMPLATES = 'client_' + app.config.client_id + '.bulk_operations.e' + this._MESSAGE_TYPE + '.templates';

                dsData = buildDataDataSource(this._FILTERABLE_DATA_URL);
                dsGroups.read().then(function () {
                    _.where(filtersDefinition, {'field': 'group'})[0].values = dsGroups.data();
                }).then(function () {
                    _this.filter.config(dsData, filtersDefinition)
                            .loadData()
                            .then(function () {
                                _this.onResize();
                            });
                });

                initToolbar(this);
                $popup = $('<span></span>').kendoNotification({position: {top: 50 }, stacking: 'down'}).data('kendoNotification');
                $('#ddlTemplates').kendoDropDownList({
                    optionLabel: 'Plantilla',
                    dataSource: this.templates,
                    dataValueField: 'uid',
                    dataTextField: 'subject',
                    change: this.loadTemplate
                }).data('kendoDropDownList').list.width(300);
                this.bind('change', this.updateBtnSend.bind(this));
                $(window).on('resize', function () {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(_this.onResize.bind(this), 500);
                });
                this.onResize();

                this._inited = true;
                return this;
            },
            _loadMessage: function (email) {
                email = email || JSON.parse(localStorage.getItem(this._DRAFT) || null);
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
                templates = templates || JSON.parse(localStorage.getItem(this._TEMPLATES) || '{}');
                this.templates.data(_.sortBy(_.values(templates), 'subject'));
            },
            load: function () {
                this._loadMessage();
                this._loadTemplates();
                return this;
            },
            loadTemplate: function (e) {
                var _this = e.sender.dataSource.parent();
                _this._loadMessage(e.sender.dataItem());
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
                return false;
            },
            send: function () {
                var _this = this;
                if (!this._messageIsReadyToBeSent()) {
                    $popup.show(this._STRINGS.COMPLETE_MESSAGE_FIRST, 'warning');
                    return;
                }
                $.post(this._SEND_SERVICE_URL, 
                    this.getServiceMessage()
                ).done(function (result) {
                    console.log(result);
                    if (result) {
                        $popup.show('Mensaje eviado satisfactoriamente', 'info');
                        localStorage.removeItem(this._DRAFT);
                        _this._restart();
                    } else {
                        $popup.show('Algo ha fallado, enviando el mensaje.', 'warning');
                    }
                }).fail(function (error) {
                    console.log(error);
                    $popup.show('Ha ocurrido un error enviando el mensaje.', 'error');
                });
            },
            getMessage: function () {
                return {
                    id: this.id,
                    to: this.to,
                    subject: this.subject,
                    message: this.message
                };
            },
            getServiceMessage: function () {
                return {
                    to: _.flatten(_.pluck(this.to.toJSON(), 'email')),
                    subject: this.subject,
                    message: this.message
                };
            },
            save: function () {
                var message = this.getMessage();
                localStorage.setItem(this._DRAFT, JSON.stringify(message));
                return message;
            },
            saveAsTemplate: function () {
                var templates = JSON.parse(localStorage.getItem(this._TEMPLATES) || '{}');
                templates[this.id] = this.save();
                localStorage.setItem(this._TEMPLATES, JSON.stringify(templates));
                this.templates.data(_.sortBy(_.values(templates), 'subject'));
            },
            _restart: function () {
                this.set('id', _.uniqueId());
                this.set('to', []);
                this.set('subject', null);
                this.set('message', null);
                this.save();
            },
            discard: function () {
                if (confirm('¿Quiere descartar el mensaje actual?')) {
                    this._restart();
                }
            },
            remove: function () {
                if (confirm('¿Quiere eliminar el mensaje actual y su plantilla asociada?')) {
                    var templates = JSON.parse(localStorage.getItem(this._TEMPLATES) || '{}');
                    delete templates[this.id];
                    localStorage.removeItem(this._DRAFT);
                    localStorage.setItem(this._TEMPLATES, JSON.stringify(templates));
                    this._restart();
                    this._loadTemplates();
                }
            },
            updateBtnSend: function (e) {
                if (!_.contains(['to', 'subject', 'message'], e.field)) return;

                var enable = this.get('to').length > 0 && this.get('subject');
                this.$toolbar.enable('#btnSend', enable);
            },
            onResize: function () {
                var $akBody = $('.akBody');
                var $filtersWrapper = $('#filtersWrapper');
                $akBody.height($akBody.parent().height() - $akBody.position().top - 10);
                $filtersWrapper.height($filtersWrapper.parent().height() - $filtersWrapper.position().top - 10);
            }
        };
    }
    
    return BulkMessagesViewModel;
});