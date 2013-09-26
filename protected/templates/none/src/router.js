define(function (require) {

    "use strict";

    var $ = require('jquery'),
        Backbone = require('backbone'),
        DefaultLayout = require('app/layouts/default'),

        $body = $('body'),
        defaultLayout = new DefaultLayout({el: $body}).render(),
        $content = $("#content", defaultLayout.el);

    return Backbone.Router.extend({

        routes: {
            "": "products",
            "category/:category_id": "products",
            "product/:product_id": "product"
        },

        products: function (category_id) {
            require(["app/views/products"], function (View) {
                var view = new View({el: $content});
                view.render();
            });
            //console.log({'controller': 'products', 'category_id': category_id});
        },

        product: function (product_id) {
            require(["app/views/product"], function (ProductsView) {
                var view = new ProductsView({el: $content});
                view.render();
            });
            console.log({'controller': 'product', 'product_id': product_id});
        }

    });

});