define(['jquery', 'lodash', 'k/kendo.binder.min'], function ($, _, kendo) {
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
                this.set('filterableData', dataSource);
                this.filtersDefinition = filtersDefinition;
                return this;
            };         
            this.loadData = function () {
                var _this = this;
                return this.filterableData.read().then(function () {
                    _this.createFilters();
                });
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