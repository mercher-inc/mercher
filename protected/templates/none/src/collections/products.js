define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        ProductModel = require('models/product');

    return Backbone.Collection.extend({
        initialize: function () {
            this.data = {};
        },
        comparator: function (firstProduct, secondProduct) {
            var firstDate = Date.parse(firstProduct.get('created')),
                secondDate = Date.parse(secondProduct.get('created'));
            if (firstDate > secondDate) {
                return -1;
            } else if (firstDate < secondDate) {
                return 1;
            } else {
                return 0;
            }
        },
        url: '/api/shops/' + appConfig.shop.id + '/products',
        model: ProductModel,
        parse: function (response) {
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