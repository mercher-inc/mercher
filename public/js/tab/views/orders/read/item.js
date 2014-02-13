define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager');

    return Layout.extend({

        template: _.template(require('text!templates/orders/read/item.html')),
        tagName: 'section',
        className: 'view orders-read-item',

        events: {

        },

        initialize: function (options) {

        },

        serialize: function () {
            return { orderItem: this.model };
        }

    });

});