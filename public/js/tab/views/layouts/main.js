define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager'),
        mainMenuView;

    return Layout.extend({

        template: _.template(require('text!templates/layouts/main.html')),
        tagName: 'body',
        className: 'layout',
        id: 'main-layout',

        events: {

        },

        initialize: function (options) {

        }

    });

});