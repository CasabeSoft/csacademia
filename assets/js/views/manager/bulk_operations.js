require(['jquery', 'app/app',
         'k/kendo.router.min', 'k/kendo.view.min', 'bootstrap'], 
function ($, app, kendo) {
    var router = new kendo.Router();
    
    function showEmail() {
        require(['app/views/manager/email-partial'], function (partial) {
            partial.show(app);
        });
    }
    
    router.route('/', showEmail);
    router.route('/email', showEmail);
    
    function start() {
        app.init('#bulkOperationsContainer');
        router.start();
    }
    
    start();
});

