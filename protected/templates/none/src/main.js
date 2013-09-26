requirejs.config({
    baseUrl: '/js',
    paths: {
        app: appConfig.appPath
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

/*
requirejs(['app/layouts/default'],
    function (Layout) {

    });
*/