define(function (require) {

    "use strict";
    var _ = require('underscore'),
        Backbone = require('backbone');

    return Backbone.View.extend({
        template: _.template(require('text!tpl/layouts/default.html')),
        render: function () {
            this.$el.html(this.template());
            return this;
        }
    });

});