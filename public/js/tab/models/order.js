define(function (require, exports, module) {

    "use strict";

    var Backbone = require('backbone'),
        OrderItemsCollection = require('collections/orderItems');

    return Backbone.Model.extend({
        urlRoot: module.config().urlRoot,

        initialize: function (options) {
            this.items = new OrderItemsCollection();
            this.items.url = this.url()+'/items';
        }
    });

});