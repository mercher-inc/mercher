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
        "backbone": {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
        "underscore": {
            exports: '_'
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

    PAYPAL.apps.MiniCart.render({
        paypalURL: 'https://www.sandbox.paypal.com/cgi-bin/webscr',
        parent: 'PayPalCart',
        formTarget: '_blank',
        edgeDistance: '15px',
        strings: {
            subtotal: 'Subtotal: ',
            shipping: 'Does not include shipping',
            button: 'Checkout',
            processing: 'Checkout'
        }
    });

    router = new Router();
    Backbone.history.start();

    router.navigate('products', {trigger: true});
});