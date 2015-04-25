requirejs.config({
    baseUrl: '/assets/libs/',
    paths: {
        app: '../js',
        jquery: '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min',
        k: '//cdn.kendostatic.com/2015.1.408/js',
        'jquery.easing': '//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min',
        'bootstrap': '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min'
    },
    shim: {
        k: ['jquery'],
        'jquery.easing': ['jquery'],
        bootstrap: ['jquery']
    },
    waitSeconds: 600
});
