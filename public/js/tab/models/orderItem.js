define(function (require, exports, module) {

    "use strict";

    var Backbone = require('backbone'),
        UniqueModel = require('backbone.uniquemodel'),
        ProductModel = require('models/product');

    return UniqueModel(
        Backbone.Model.extend({
            parse: function (response, options) {
                var hash = _.clone(response);
                this.product = new ProductModel(hash.product);
                delete hash.product;
                return hash;
            }
        })
    );

});