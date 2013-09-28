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

fbUser = {};

require(['jquery', 'backbone', 'app/router'], function ($, Backbone, Router) {

    window.fbAsyncInit = function () {

        FB.init({
            "appId": "631238416902634",
            "cookie": true,
            "xfbml": true,
            "status": true,
            "channelUrl": "http:\/\/tab.mercher.dev\/channel.html"
        });

        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                FB.api('/me?fields=name,currency', function (response) {
                    fbUser = response;
                    var router = new Router();
                    Backbone.history.start();
                });
            } else {
                FB.login(function () {
                }, {scope: 'publish_actions'});
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