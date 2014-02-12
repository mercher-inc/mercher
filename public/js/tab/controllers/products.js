define(function (require, exports, module) {

    "use strict";

    //requirements
    var Controller = require('backbone.controller'),
        productsView;

    return Controller.extend({
        routes: {
            '': 'index',
            'products': 'index',
            'products/:product_id': 'read'
        },

        initialize: function() {

        },

        index: function () {
            var controller = this,
                mainLayout = this.options.router.mainLayout;

            require(['views/products/index'], function (ProductsView) {

                if (!(productsView instanceof ProductsView)) {
                    productsView = new ProductsView({controller: controller});

                    if (module.config().productsCollection) {
                        productsView.collection.reset(
                            module.config().productsCollection.data.models
                        );
                        productsView.collection.count = module.config().productsCollection.data.count;
                        productsView.collection.params = module.config().productsCollection.params;
                    } else {
                        productsView.collection.fetch({
                            data: productsView.collection.params
                        });
                    }
                }

                mainLayout.setView("section#content", productsView);
                productsView.render();
            });

            //track page view
            require(['ga'], function (ga) {
                _.each(ga.getAll(), function(tracker){
                    tracker.send(
                        'pageview',
                        {
                            page: 'products',
                            title: 'Products'
                        }
                    );
                });
            });
        },

        read: function(product_id) {


            //track page view
            require(['ga'], function (ga) {
                _.each(ga.getAll(), function(tracker){
                    tracker.send(
                        'pageview',
                        {
                            page: 'products/' + product_id,
                            title: 'Product'
                        }
                    );
                });
            });
        }
    });

});