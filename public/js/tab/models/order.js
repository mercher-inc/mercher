define(function (require, exports, module) {

    "use strict";

    var Backbone = require('backbone'),
        UniqueModel = require('backbone.uniquemodel'),
        OrderItemsCollection = require('collections/orderItems');

    return UniqueModel(
        Backbone.Model.extend({
            urlRoot: module.config().urlRoot,

            initialize: function (options) {
                this.items = new OrderItemsCollection();
                this.items.url = this.url() + '/items';
            },

            createPayRequest: function (options) {
                var order = this;
                if (order.get('status') == 'new') {
                    $.ajax(
                        {
                            url: '/api/createPayRequest',
                            data: {
                                'order_id': order.id
                            },
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                order.set(data);
                                if (_.isObject(options) && _.isFunction(options.success)) {
                                    options.success(order);
                                }
                                //console.log(view.model);
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                if (_.isObject(options) && _.isFunction(options.error)) {
                                    options.error(order);
                                }
                                //console.log(jqXHR, textStatus, errorThrown);
                            }
                        }
                    );
                }
            }
        })
    );

});