requirejs.config({
    baseUrl: '/assets/libs/',
    paths: {
        app: '../js/',
        jquery: '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min',
        k: '//cdn.kendostatic.com/2014.2.903/js/',
        'jquery.easing': '//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min',
        'bootstrap': '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min'
    },
    shim: {
        /*k: {
            exports: 'kendo',
            deps: ['jquery']
        },*/
        'jquery.easing': { deps: ['jquery'] },
        bootstrap: { deps: ['jquery'] }
    },
    waitSeconds: 600
});
/*
define(['jquery', 'bootstrap'], function ($) {
    return {
        version: 1.3
    };
});*/