define(function (require) {

    "use strict";

    var $ = require('jquery'),
        Backbone = require('backbone'),
        DefaultLayout = require('app/views/layouts/default'),
        CategoriesCollection = require('app/collections/categories'),
        categoriesCollection = new CategoriesCollection(),

        $body = $('body'),
        defaultLayout = new DefaultLayout({el: $body, categories: categoriesCollection}).render(),
        $content = $("#content", defaultLayout.el);

    return Backbone.Router.extend({

        routes: {
            "": "products",
            "category/:category_id": "products",
            "product/:product_id": "product"
        },

        products: function (category_id) {
            $content.fadeOut('fast', function () {
                require(["app/views/products/list"], function (View) {
                    var view = new View({el: $content});
                    view.render();
                    $content.fadeIn('fast');
                });
            });
        },

        product: function (product_id) {
            $content.fadeOut('fast', function () {
                require(["app/views/product/item"], function (View) {
                    var view = new View({el: $content});
                    view.render();
                    $content.fadeIn('fast');
                });
            });
        }

    });

});