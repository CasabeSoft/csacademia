require(['jquery', 'app/app',
         'k/kendo.router.min', 'k/kendo.view.min', 'bootstrap'], 
function ($, app, kendo) {
    var router = new kendo.Router();
    
    function showEmail() {
        require(['app/views/manager/email-partial'], function (partial) {
            partial.show(app);
        });
    }

    function showSms() {
        require(['app/views/manager/sms-partial'], function (partial) {
            partial.show(app);
        });
    }
    
    router.route('/', showEmail);
    router.route('/email', showEmail);
    router.route('/sms', showSms);
    
    function start() {
        app.init('#bulkOperationsContainer');
        router.start();
    }
    
    start();
});

