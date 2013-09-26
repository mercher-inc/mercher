define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        ProductModel = require('app/models/product');

    return Backbone.Collection.extend({
        initialize: function () {
            this.data = {};
        },
        url: '/api/shops/' + appConfig.shop.id + '/products',
        model: ProductModel,
        parse     : function (response) {
            this.data.limit = response.limit;
            this.data.count = response.count;
            this.data.offset = response.offset;
            if (typeof response.url != 'undefined') {
                this.url = response.url;
            }
            return response.models;
        }
    });

});