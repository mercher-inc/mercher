define(function (require, exports, module) {

    "use strict";

    var Backbone = require('backbone'),
        ProductModel = require('models/product');

    return Backbone.Model.extend({
        urlRoot: module.config().urlRoot,
        parse: function(response, options) {
            var hash = _.clone(response);
            this.product = new ProductModel(hash.product);
            delete hash.product;
            return hash;
        }
    });

});