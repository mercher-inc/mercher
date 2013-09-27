/*!
 * Mercher v1.0.0
 * Template None
 */

requirejs.config({
    baseUrl: '/js',
    paths: {
        app: appConfig.appPath,
        bootstrap: '/bootstrap/dist/js/bootstrap',
        facebook: '//connect.facebook.net/en_US/all'
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

require(['jquery', 'backbone', 'facebook', 'app/router'], function ($, Backbone, FB, Router) {
    FB.Event.subscribe('auth.statusChange', function (response) {
        if (response.status === 'connected') {
            FB.api('/me?fields=name,currency', function (response) {
                fbUser = response;
                var router = new Router();
                Backbone.history.start();
            });
        } else {
            FB.login(function(){}, {scope: 'publish_actions'});
        }
    });
});