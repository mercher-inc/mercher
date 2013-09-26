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

        },

        render: function () {
            this.$el.html(template());
            return this;
        }

    });

});