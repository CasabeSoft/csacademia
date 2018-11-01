/* global kendo */
define(['jquery', 'text!api/config/front'], function ($, config) {
    var App = {
        config: JSON.parse(config),
        layout: null,
        views: [],
        container: null,
        init: function (container) { 
            this.container = container;
            this.layout = new kendo.Layout('<div class="content"></div>', { wrap: false });
            this.layout.render($(container));
        },
        getView: function (name, view, viewModel) {
            if (!this.views[name]) {
                this.views[name] = new kendo.View(view, { model: viewModel, wrap: false });
            }
            return this.views[name];
        },
        showView: function (name, view, viewModel) {
            var $content = $(this.container + ' .content'),
                kendoView = this.getView(name, view, viewModel);
            this.layout.showIn($content, kendoView);
            return kendoView;
        }        
    };
    
    return App;
});