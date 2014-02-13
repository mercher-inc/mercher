define(function (require, exports, module) {

    "use strict";

    //requirements
    var Controller = require('backbone.controller'),
        ordersView;

    return Controller.extend({
        routes: {
            'orders': 'index',
            'orders/:order_id': 'read'
        },

        initialize: function() {

        },

        index: function () {

        },

        read: function(order_id) {
            var controller = this,
                mainLayout = this.options.router.mainLayout;

            require(['views/orders/read'], function (OrderView) {
                var orderView = new OrderView({controller: controller});
                orderView.model.id = order_id;
                orderView.model.fetch();

                mainLayout.setView("section#content", orderView);
                orderView.render();
            });

            //track page view
            require(['ga'], function (ga) {
                _.each(ga.getAll(), function(tracker){
                    tracker.send(
                        'pageview',
                        {
                            page: 'orders/' + order_id,
                            title: 'Order #' + order_id
                        }
                    );
                });
            });
        }
    });

});