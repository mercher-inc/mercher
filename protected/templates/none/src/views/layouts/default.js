define(function (require) {

    "use strict";
    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        Bootstrap = require('bootstrap'),
        tpl = require('text!app/tpl/layouts/default.html'),
        template = _.template(tpl);

    return Backbone.View.extend({

        initialize: function () {
            this.listenTo(this.options.categories, "sync", this.printCategories);
            this.options.categories.fetch({data: {limit: 100}});
        },

        render: function () {
            this.$el.html(template());
            return this;
        },

        printCategories: function () {
            $('#categories_menu', this.$el).append('<li><a href="#">All</a></li>');
            this.options.categories.each(function(category) {
                $('#categories_menu', this.$el).append('<li><a href="#category/'+category.get('id')+'">'+category.get('title')+'</a></li>');
            }, this);
            return this;
        }

    });

});