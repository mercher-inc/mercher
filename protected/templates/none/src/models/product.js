define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        shop = require('shop');

    return Backbone.Model.extend({
        urlRoot: function () {
            return '/api/shops/' + shop.get("id") + '/products/';
        }
    });

});