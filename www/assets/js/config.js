requirejs.config({
    baseUrl: '/assets/lib/',
    paths: {
        app: '../js',
        jquery: '../../node_modules/jquery/dist/jquery.min',
        k: '//kendo.cdn.telerik.com/2015.1.408/js',
        'jquery.easing': '//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min',
        bootstrap: '../../node_modules/bootstrap/dist/js/bootstrap.min',
        views: '/assets/html',
        lodash: '//cdnjs.cloudflare.com/ajax/libs/lodash.js/3.9.0/lodash.min',
        api: '/api'
    },
    shim: {
        k: ['jquery'],
        'jquery.easing': ['jquery'],
        bootstrap: ['jquery']
    },
    waitSeconds: 600
});
