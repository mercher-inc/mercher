define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone');

    return Backbone.Model.extend({
        urlRoot: function () {
            return '/api/shops/' + appConfig.shop.id + '/products/';
        }
    });

});