define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager');

    return Layout.extend({

        template: _.template(require('text!templates/nav/main.html')),
        tagName: 'nav',
        className: 'view nav-main navbar navbar-tab navbar-fixed-top',
        attributes: {
            role: 'navigation'
        },

        events: {

        },

        initialize: function (options) {

            this.listenTo(this.router, 'route', function (route, params) {
                this.$('.navbar-nav>li').removeClass('active');
                switch (route) {
                    case '':
                        this.$('.navbar-nav>li>a[href^="/products"]').parent().addClass('active');
                        break;
                    case 'products':
                        this.$('.navbar-nav>li>a[href^="/products"]').parent().addClass('active');
                        break;
                    case 'orders':
                        this.$('.navbar-nav>li>a[href^="/orders"]').parent().addClass('active');
                        break;
                    case 'orders/:order_id':
                        this.$('.navbar-nav>li>a[href^="/orders"]').parent().addClass('active');
                        break;
                    default:
                        console.log(route);
                }
            });

        }

    });

});