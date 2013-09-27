define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        Bootstrap = require('bootstrap'),
        tpl = require('text!app/tpl/products/list.html'),
        ProductsListItemView = require('app/views/products/list/item'),
        template = _.template(tpl);

    return Backbone.View.extend({

        initialize: function () {
            this.listenTo(this.collection, "sync", this.render);
        },

        events: {
            "click .showMore": "showMore"
        },

        render: function () {
            this.$el.html(template({collection: this.collection}));

            var $list = $('.list:first', this.$el);
            $list.empty();
            var $row = $('<div class="row"></div>');

            _.each(this.collection.models, function (product, i) {
                if (i % 3 == 0) {
                    $row = $('<div class="row"></div>');
                    $row.appendTo($list);
                }
                $row.append(new ProductsListItemView({model: product}).render().el);
            }, this);

            return this;
        },

        showMore: function () {
            this.collection.data.offset = this.collection.length;
            this.collection.fetch({
                data: this.collection.data,
                remove: false
            });
        }

    });

});