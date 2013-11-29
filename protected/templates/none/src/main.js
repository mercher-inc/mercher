/*!
 * Mercher v1.0.0
 * Template None
 */

requirejs.config({
    baseUrl: '/js',
    paths: {
        "app": appConfig.appPath,
        "bootstrap": '/bootstrap/dist/js/bootstrap',
        "facebook": '//connect.facebook.net/en_US/all',
        "google-analytics": "//www.google-analytics.com/analytics"
    },
    shim: {
        "underscore": {
            exports: '_'
        },
        "backbone": {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
        "bootstrap": {
            deps: ['jquery']
        },
        "facebook": {
            exports: 'FB'
        },
        "google-analytics": {
            exports: "ga"
        }
    },
    waitSeconds: 0
});

router = null;

require(['jquery', 'backbone', 'app/router', 'minicart.min'], function ($, Backbone, Router, Minicart) {

    router = new Router();
    Backbone.history.start();

    router.navigate('products', {trigger: true});
});