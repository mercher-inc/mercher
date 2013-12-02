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
        "minicart": "/js/minicart.min",
        "bootstrap": "/lib/bootstrap/dist/js/bootstrap",
        "facebook": "//connect.facebook.net/en_US/all",
        "google-analytics": "//www.google-analytics.com/analytics",
        "fb": "../fb",
        "ga": "../ga"
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

require(['jquery', 'backbone', 'router', 'minicart'], function ($, Backbone, Router, Minicart) {

    router = new Router();
    Backbone.history.start();

    router.navigate('products', {trigger: true});
});