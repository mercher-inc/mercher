requirejs.config({
    baseUrl: '/js',
    paths: {
        app: './'
    },
    shim: {
        'backbone': {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
        'underscore': {
            exports: '_'
        }
    },
    waitSeconds: 0
});

requirejs(['backbone'],
    function (Backbone) {

    });