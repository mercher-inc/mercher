define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        Bootstrap = require('bootstrap'),
        tpl = require('text!app/tpl/products/list.html'),
        template = _.template(tpl);

    return Backbone.View.extend({

        initialize: function () {

        },

        render: function () {
            this.$el.html(template());
            var list = $(".list:first", this.el);
            console.log(list);
            return this;
        }

    });

});