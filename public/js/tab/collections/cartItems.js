define(function (require, exports, module) {

    "use strict";

    var Backbone = require('backbone'),
        CartItemModel = require('models/cartItem');

    return Backbone.Collection.extend({
        model: CartItemModel,
        url: module.config().url,
        params: {},

        initialize: function (options) {

        },

        parse: function(response) {
            this.count = response.count;
            this.limit = response.limit;
            this.offset = response.offset;
            return response.models;
        }
    });

});