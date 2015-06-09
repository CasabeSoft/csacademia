define(['jquery', 'lodash', 'k/kendo.binder.min'], function ($, _, kendo) {
    function FilterableData(data) {
        this.id = null;
        this.name = null;
        this.type = null;
        this.isActive = true;
        
        $.extend(this, data);
    }
    
    var FilterableDTO = {
        id: null,
        name: null,
        type: null,
        isActive: true
    };
    
    var Filter = {
        name: null,
        field: null,
        values: []
    };
    
    var _filtersDefinition = [
        {
            name: 'Tipo',
            field: 'type',
            type: 'number',
            values: [
                {value: 1, text: 'Alumno'},
                {value: 2, text: 'Profesor'},
                {value: 3, text: 'Familiar'}
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
            name: 'Grupo',
            field: 'group',
            type: 'number',
            values: [
                {value: 1, text: 'G1'},
                {value: 2, text: 'G2'},
                {value: 3, text: 'G3'}
            ]
        }
    ];
    
    var FilterableDataViewModel =  kendo.data.ObservableObject.extend({
        init: function (data) {
            kendo.data.ObservableObject.fn.init.call(this, $.extend({}, FilterableDTO, data));
        }    
    });

    var data = [
            new FilterableData({id: 1, name: 'Juan López', type: 1, isActive: true, group: 1, email: 'juan@lopez.com'}),
            new FilterableData({id: 2, name: 'María de las Mercedes', type: 2, isActive: true, email: 'maria@lopez.com'}),
            new FilterableData({id: 3, name: 'Grupo 1', type: 3, isActive: true, email: ['pepe@p.com', 'mark@us.es']}),
            new FilterableData({id: 6, name: 'Juan Marquéz', type: 1, isActive: false, group: 1, email: 'juan@marquez.es'}),
            new FilterableData({id: 5, name: 'Marta Marquéz', type: 1, isActive: true, group: 2, email: 'marta@marquez.es'}),
            new FilterableData({id: 4, name: 'Paco Pérez', type: 2, isActive: false, email: 'paco@perez.es'}),
            new FilterableData({id: 7, name: 'Carlos B', type: 1, isActive: true, email: 'pauste@gmail.com'})
        ];
        
    var dsData = new kendo.data.DataSource({
        sort: { field: 'name', dir: 'asc' },
        requestStart: function (e) {
            kendo.ui.progress($('#filter'), true);
        },
        requestEnd: function () {
            kendo.ui.progress($('#filter'), false);
        }
    });
    
    var FilterData = kendo.data.ObservableObject.extend({
        filtersDefinition: [],
        init: function () {
            this.checkAll = false;
            this.order = 1;
            this.filterableData = [];
            this.query = null;
            this.filters = [];
            
            this.toogleCheckAll = function () {
                var selected = this.checkAll;
                _.each(this.filterableData.view(), function (data) {
                    data.set('selected', selected);
                });
            };
            this.config = function (dataSource, filtersDefinition) {
                this.set('filterableData', dataSource || dsData);
                this.filtersDefinition = filtersDefinition || _filtersDefinition;
                return this;
            };         
            this.loadData = function () {
                this.filterableData.data(data);
                this.createFilters();
            };
            this.createFilters = function () {
                var filters = [],
                    data = this.filterableData.data();
                kendo.ui.progress($('#filter'), true);
                filters = this.filtersDefinition.map(function (definition) {
                    var newFilter = _.clone(definition),
                        currentValues = _.uniq(_.pluck(data, newFilter.field).sort(), true);
                    newFilter.currentValues = newFilter.values.filter(function (value) {
                        return _.contains(currentValues, value.value); 
                    });
                    return newFilter;
                });
                this.set('filters', filters);
                kendo.ui.progress($('#filter'), false);
            };
            this.applyFilter = function(addOrUpdate, filter) {
                var currentFilters = this.filterableData.filter(),
                    newFilter = addOrUpdate ?
                        addOrUpdateFilter(filter, currentFilters) :
                                removeFilterForField(filter.field, currentFilters);
                this.filterableData.filter(newFilter);
            };
            /**
             * Ejecuta una búsqueda entre los datos disponibles en `filterableData`, de
             * momento, solo busca por nombre
             */
            this.doSearch = function () {
                var name = this.get('query'),
                    filter = {field: 'name', operator: 'contains', value: name};
                this.applyFilter(name, filter);
            };
            /**
             * Actualiza el filtro, cuando se marca o desmarca un valor de la lista
             * de valores por campo a filtrar
             * @param {Event} e - Evento Change 
             */
            this.onSelectedChange = function (e) {
                var definition = e.data.parent().parent(),
                    values = _.pluck(_.where(e.data.parent(), {'selected': true}), 'value'),
                    filter = {
                        field: definition.field, 
                        logic: 'or',
                        filters: _.map(values, function (value) { 
                            return {field: definition.field, operator: 'eq', value: convert(value, definition.type) };
                        })
                    };
                this.set('checkAll', false);
                this.applyFilter(values.length > 0, filter);
            };
            this.toogleOrder = function () {
                var ORDERS = [{}, {field: 'name', dir: 'asc'}, {field: 'name', dir: 'desc'}];
                this.set('order', (this.order + 1) % 3);
                this.filterableData.sort(ORDERS[this.order]);
                return false;
            };
            this.orderIconClass = function () {
                var SORT_ICONS = ['glyphicon-sort', 'glyphicon-sort-by-alphabet', 'glyphicon-sort-by-alphabet-alt'];
                return 'glyphicon ' + SORT_ICONS[this.get('order')];
            };
            this.orderTitle = function () {
                var SORT_TITLES = ['Ordenar', 'Cambiar orden', 'Quitar orden'];
                return SORT_TITLES[this.get('order')];
            };
            
            kendo.data.ObservableObject.fn.init.call(this);
        }
    });
    
    function convert(value, type) {
        switch (type) {
            case 'number': 
                return Number(value);
                break;
            case 'boolean':
                return value === 'true';
                break;
            case 'date':
                return new Date(value);
                break;
            default:
                return value;
        }
    }
    
    /**
     * Eliminar un filtro de una definición de filtros de un DataSource,
     * a partir del nombre del campo del filtro
     * @param {String} field - Nombre del campo cuyo filtro se quiere eliminar
     * @param {Object} currentFilters - Definición de filtros del DataSource
     * @returns {Array} - Colección de filtros resultante de la eliminación
     */
    function removeFilterForField(field, currentFilters) {
        return !currentFilters ?
            [] :
            _.reject(currentFilters.filters, function (filter) {
                return filter.field === field;
            });
    }
    
    /**
     * Añade un nuevo filtro o actualiza un filtro existente a la definición
     * de filtros de un DataSource
     * @param {Object} newFilter - Definición del filtro a añadir o actualizar
     * @param {Object} currentFilters - Definición de filtros del DataSource
     * @returns {Array} - Colección de filtros resultante de la actualización
     */
    function addOrUpdateFilter(newFilter, currentFilters) {
        return !currentFilters ? 
            newFilter :
            removeFilterForField(newFilter.field, currentFilters).concat(newFilter);
    }

    return FilterData;
});