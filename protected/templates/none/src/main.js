/*!
 * Mercher v1.0.0
 * Template None
 */

requirejs.config({
    baseUrl: '/js',
    paths: {
        app: appConfig.appPath,
        bootstrap: '/bootstrap/dist/js/bootstrap'
    },
    shim: {
        'backbone': {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
        'underscore': {
            exports: '_'
        },
        'bootstrap': {
            deps: ['jquery']
        },
        'facebook': {
            exports: 'FB'
        }

    },
    waitSeconds: 0
});

router = null;
fbUser = {
    id: null,
    name: "Guest",
    currency: {
        currency_exchange: 10,
        currency_exchange_inverse: 0.1,
        currency_offset: 100,
        usd_exchange: 1,
        usd_exchange_inverse: 1,
        user_currency: "USD"
    }
};

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

    window.fbAsyncInit = function () {

        FB.init({
            "appId": "631238416902634",
            "cookie": true,
            "xfbml": true,
            "status": true,
            "channelUrl": "http:\/\/tab.mercher.dev\/channel.html"
        });

        FB.Canvas.setAutoGrow(true);

        FB.getLoginStatus(function (response) {

            router = new Router();
            Backbone.history.start();

            if (appConfig.requestData && appConfig.requestData.product_id) {
                router.navigate('products/' + appConfig.requestData.product_id, {trigger: true});
            } else {
                router.navigate('products', {trigger: true});
            }

            if (response.status === 'connected') {
                FB.api('/me?fields=name,currency', function (response) {
                    fbUser = response;
                });
            }
        });
    };

    (function (d, s, id) {
        var js,
            fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

});