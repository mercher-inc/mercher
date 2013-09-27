define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        Bootstrap = require('bootstrap'),
        tpl = require('text!app/tpl/products/list/item.html'),
        template = _.template(tpl);

    return Backbone.View.extend({

        className: 'col-sm-4',

        initialize: function () {
            this.listenTo(this.model, "sync", this.render);
        },

        render: function () {
            this.$el.html(template({model: this.model}));
            return this;
        }

    });

});