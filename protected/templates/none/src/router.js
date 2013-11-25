define(function (require) {

    "use strict";

    var $ = require('jquery'),
        Backbone = require('backbone'),
        DefaultLayout = require('app/views/layouts/default'),
        CategoriesCollection = require('app/collections/categories'),
        categoriesCollection = new CategoriesCollection(),
        activeView = false,

        $body = $('body'),
        defaultLayout = new DefaultLayout({el: $body, categories: categoriesCollection}).render(),
        $content = $("#content", defaultLayout.el);

    return Backbone.Router.extend({

        routes: {
            //"": "products",
            "products": "products",
            "category/:category_id/products": "products",
            "products/:product_id": "product"
        },

        products: function (category_id) {
            require(["app/views/products/list", "app/collections/products"], function (View, Collection) {

                FB.Canvas.scrollTo(0,0);

                if (activeView) {
                    activeView.setElement(null);
                    activeView.remove();
                }

                var collection = new Collection();

                collection.data.limit = 9;
                activeView = new View({
                    el: $content,
                    collection: collection
                });

                if (category_id) {
                    activeView.collection.data.category_id = category_id;
                } else {
                    activeView.collection.data.category_id = null;
                    delete activeView.collection.data.category_id;
                }
                activeView.collection.data.offset = 0;

                activeView.collection.fetch({data: activeView.collection.data});
            });
        },

        product: function (product_id) {
            require(["app/views/products/item", "app/models/product"], function (View, Model) {

                FB.Canvas.scrollTo(0,0);

                if (activeView) {
                    activeView.setElement(null);
                    activeView.remove();
                }

                var model = new Model({id: product_id});
                activeView = new View({
                    el: $content,
                    model: model
                });

                model.fetch();
            });
        }

    });

});