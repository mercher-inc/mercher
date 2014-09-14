/*!
 * Mercher v2
 */

requirejs.config({
    enforceDefine: true,
    paths: {
        app: 'tab/app',
        controllers: 'tab/controllers',
        views: 'tab/views',
        templates: 'tab/templates',
        collections: 'tab/collections',
        models: 'tab/models',
        og: 'tab/og',
        jquery: [
            "//code.jquery.com/jquery-1.11.0",
            "vendors/jquery/jquery-1.11.0"
        ],
        bootstrap: [
            "//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap",
            "vendors/bootstrap/dist/js/bootstrap"
        ],
        underscore: [
            "//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore",
            "vendors/underscore/underscore-1.5.2"
        ],
        backbone: [
            "//cdnjs.cloudflare.com/ajax/libs/backbone.js/1.1.0/backbone",
            "vendors/backbone/backbone-1.1.0"
        ],
        text: [
            "//cdnjs.cloudflare.com/ajax/libs/require-text/2.0.10/text",
            "vendors/text/text-2.0.10"
        ],
        modernizr: [
            "//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.dev",
            "vendors/modernizr/modernizr-2.7.1"
        ],
        "backbone.layoutmanager": [
            "//cdnjs.cloudflare.com/ajax/libs/backbone.layoutmanager/0.9.4/backbone.layoutmanager",
            "vendors/backbone.layoutmanager/backbone.layoutmanager-0.9.4"
        ],
        "backbone.controller": "vendors/backbone.controller/backbone.controller-0.3.0",
        "backbone.uniquemodel": "vendors/backbone.uniquemodel/backbone.uniquemodel",
        purl: [
            "//cdnjs.cloudflare.com/ajax/libs/jquery-url-parser/2.3.1/purl",
            "vendors/purl/purl-2.3.1"
        ],
        DGFlow: '//www.paypalobjects.com/js/external/dg',
        DGFlowMini: '//www.paypalobjects.com/js/external/apdg',
        facebook: "//connect.facebook.net/en_US/all",
        "google-analytics": "//www.google-analytics.com/analytics",
        fb: "tab/fb",
        ga: "tab/ga"
    },
    baseUrl: "/js",
    shim: {
        jquery: {
            exports: '$'
        },
        underscore: {
            exports: '_'
        },
        backbone: {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
        text: ['backbone'],
        "backbone.controller": {
            deps: ['backbone'],
            exports: 'Backbone.Controller'
        },
        "backbone.layoutmanager": {
            deps: ['backbone'],
            exports: 'Backbone.Layout'
        },
        "backbone.uniquemodel": {
            deps: ['backbone'],
            exports: 'Backbone.UniqueModel'
        },
        bootstrap: {
            exports: '$',
            deps: ['jquery']
        },
        purl: {
            deps: ['jquery'],
            exports: 'purl'
        },
        modernizr: {
            exports: 'Modernizr'
        },
        DGFlow: {
            exports: 'PAYPAL.apps.DGFlow'
        },
        DGFlowMini: {
            exports: 'PAYPAL.apps.DGFlowMini'
        },
        facebook: {
            exports: 'FB'
        },
        "google-analytics": {
            exports: "ga"
        },
        fb: ["facebook"],
        ga: ["google-analytics"]
    },
    urlArgs: { 'bust': Date.now() },
    waitSeconds: 15
});