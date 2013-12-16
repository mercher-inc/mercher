/*!
 * Mercher v1.0.0
 * Template None
 */

requirejs.config({
    paths: {
        "jquery": "/js/jquery",
        "text": "/js/text",
        "underscore": "/js/underscore",
        "backbone": "/js/backbone",
        "minicart": "/minicart/dist/minicart",
        "bootstrap": "/bootstrap/dist/js/bootstrap",
        "facebook": "//connect.facebook.net/en_US/all",
        "google-analytics": "//www.google-analytics.com/analytics",
        "fb": "../fb",
        "ga": "../ga",
        "shop": "../shop"
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

var router = null;

require(['backbone', 'router'], function (Backbone, Router) {

    //instantiate router
    router = new Router();
    Backbone.history.start();

    //navigating to products
    router.navigate('products', {trigger: true});
});