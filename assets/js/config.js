requirejs.config({
    baseUrl: '/assets/lib/',
    paths: {
        app: '../js',
        jquery: '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min',
        k: '//cdn.kendostatic.com/2015.1.408/js',
        'jquery.easing': '//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min',
        bootstrap: '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min',
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
