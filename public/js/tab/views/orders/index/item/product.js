define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager');

    return Layout.extend({
        template: _.template(require('text!templates/orders/index/item/product.html')),
        tagName: 'div',
        className: 'view orders-index-item-product',

        events: {

        },

        initialize: function (options) {

        },

        serialize: function () {
            return { orderItem: this.model };
        }

    });

});