define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        CategoriesModel = require('app/models/category');

    return Backbone.Collection.extend({
        url: '/api/shops/' + appConfig.shop.id + '/categories',
        model: CategoriesModel,
        parse     : function (response) {
            this.data = {};
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