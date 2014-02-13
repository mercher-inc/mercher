define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager'),
        OrderModel = require('models/order'),
        OrderModel = require('models/order');

    return Layout.extend({
        model: new OrderModel(),

        template: _.template(require('text!templates/orders/read.html')),
        tagName: 'div',
        className: 'view orders-read',

        events: {

        },

        initialize: function (options) {

        },

        serialize: function () {
            return { order: this.model };
        }

    });

});