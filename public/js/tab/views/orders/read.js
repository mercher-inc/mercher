define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager'),
        ItemView = require('views/orders/read/item');

    require('bootstrap');

    return Layout.extend({
        template: _.template(require('text!templates/orders/read.html')),
        tagName: 'div',
        className: 'view orders-read',

        events: {
            "click .showMore": 'showMore',
            "click .btnCheckOut.payPal": 'onBtnCheckOutWithPayPalClick'
        },

        initialize: function (options) {
            var view = this;

            this.model.items.fetch();

            this.listenTo(this.model.items, 'sync', function (collection, resp, options) {
                if (collection.count > collection.length) {
                    this.$('.showMore').show();
                } else {
                    this.$('.showMore').hide();
                }
            });

            this.listenTo(this.model.items, 'add', function (model, collection, options) {
                var itemView = new ItemView({model: model, controller: view.controller});
                view.insertView('.order-items .list', itemView);
                itemView.render();
            });

            this.listenTo(this.model, 'change:status', function(){
                this.render();
            });
        },

        beforeRender: function () {
            this.removeView('.order-items .list');
            this.model.items.each(function (model) {
                this.insertView('.order-items .list', new ItemView({model: model, controller: this.controller}));
            }, this);
        },

        afterRender: function () {
            if (this.model.items.count > this.model.items.length) {
                this.$('.showMore').show();
            } else {
                this.$('.showMore').hide();
            }
        },

        serialize: function () {
            var created = new Date(this.model.get('created'));
            var orderDate = created.getMonth() + '/' + created.getDate() + '/' + created.getFullYear();

            var orderStatus = this.model.get('status');
            switch (this.model.get('status')) {
                case 'new':
                    orderStatus = 'New order';
                    break;
                case 'waiting_for_payment':
                    orderStatus = 'Waiting for payment';
                    break;
                case 'accepted':
                    orderStatus = 'Accepted';
                    break;
                case 'rejected':
                    orderStatus = 'Rejected';
                    break;
                case 'approved':
                    orderStatus = 'Approved';
                    break;
                case 'completed':
                    orderStatus = 'Completed';
                    break;
            }

            return { order: this.model, orderDate: orderDate, orderStatus: orderStatus };
        },

        showMore: function () {
            this.$('.showMore').button('loading');
            this.listenToOnce(this.model.items, 'sync', function (collection, resp, options) {
                this.$('.showMore').button('reset');
            });

            this.model.items.offset += this.model.items.limit;
            this.model.items.fetch({
                data: {
                    limit: this.model.items.limit,
                    offset: this.model.items.offset
                },
                remove: false
            });

        },

        onBtnCheckOutWithPayPalClick: function (e) {
            var view = this;
            this.$('.btnCheckOut').button('loading');

            var checkPaymentCompleteCallback = function () {
                $.ajax(
                    {
                        url: '/api/checkPaymentDetails',
                        data: {
                            'order_id': view.model.id
                        },
                        type: 'GET',
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            view.model.set(data);
                            if (window.Mercher.embeddedPPFlow.isOpen()) {
                                setTimeout(function(){checkPaymentCompleteCallback()}, 2500);
                            } else {
                                view.$('.btnCheckOut').button('reset');
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR, textStatus, errorThrown);
                            window.Mercher.embeddedPPFlow.closeFlow();
                        }
                    }
                );
            };

            if (this.model.get('status') == 'new') {
                this.model.createPayRequest({
                    success: function (order) {
                        require(['DGFlow'], function (DGFlow) {
                            window.Mercher.embeddedPPFlow = new DGFlow({expType: 'light'});
                            window.Mercher.embeddedPPFlow.startFlow('https://www.sandbox.paypal.com/webapps/adaptivepayment/flow/pay?paykey=' + view.model.get('pay_key'));
                            checkPaymentCompleteCallback();
                        });
                    },
                    error: function () {
                        view.$('.btnCheckOut').button('reset');
                    }
                });
            } else {
                require(['DGFlow'], function (DGFlow) {
                    window.Mercher.embeddedPPFlow = new DGFlow({expType: 'light'});
                    window.Mercher.embeddedPPFlow.startFlow('https://www.sandbox.paypal.com/webapps/adaptivepayment/flow/pay?paykey=' + view.model.get('pay_key'));
                    checkPaymentCompleteCallback();
                });
            }
        }



    });

});