define(function (require) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Backbone = require('backbone');

    return Backbone.View.extend({

        template: _.template(require('text!tpl/layouts/default.html')),

        render: function () {
            //render layout
            this.$el.html(this.template());
            //return view
            return this;
        }
    });

});