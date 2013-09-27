define(function (require) {

    "use strict";

    var $ = require('jquery'),
        Backbone = require('backbone'),
        DefaultLayout = require('app/views/layouts/default'),
        CategoriesCollection = require('app/collections/categories'),
        categoriesCollection = new CategoriesCollection(),
        categoriesView = false,

        $body = $('body'),
        defaultLayout = new DefaultLayout({el: $body, categories: categoriesCollection}).render(),
        $content = $("#content", defaultLayout.el);

    //console.log(FB);

    return Backbone.Router.extend({

        routes: {
            "": "products",
            "category/:category_id": "products",
            "product/:product_id": "product"
        },

        products: function (category_id) {
            require(["app/views/products/list", "app/collections/products"], function (View, Collection) {

                if (!categoriesView) {

                    var collection = new Collection();

                    collection.data.limit = 9;
                    categoriesView = new View({
                        el: $content,
                        collection: collection
                    });

                }

                console.log(categoriesView);

                if (category_id) {
                    categoriesView.collection.data.category_id = category_id;
                } else {
                    categoriesView.collection.data.category_id = null;
                    delete categoriesView.collection.data.category_id;
                }
                categoriesView.collection.data.offset = 0;

                categoriesView.collection.fetch({data: categoriesView.collection.data});
            });
        },

        product: function (product_id) {
            require(["app/views/product/item"], function (View) {
                var view = new View({el: $content});
                view.render();
            });
        }

    });

});