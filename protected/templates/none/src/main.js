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
            "appId": appConfig.FB.appId,
            "cookie": true,
            "xfbml": true,
            "status": true,
            "channelUrl": appConfig.FB.channelUrl
        });

        //FB.Canvas.setAutoGrow(true);

        router = new Router();
        Backbone.history.start();

        if (appConfig.requestData && appConfig.requestData.product_id) {
            router.navigate('products/' + appConfig.requestData.product_id, {trigger: true});
        } else {
            router.navigate('products', {trigger: true});
        }
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

    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    if (typeof appConfig.GA != 'undefined' && typeof appConfig.GA.id != 'undefined') {
        ga('create', appConfig.GA.id);
    }

});