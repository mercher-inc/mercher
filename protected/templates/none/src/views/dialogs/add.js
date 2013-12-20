define(function (require) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Backbone = require('backbone');

    return Backbone.View.extend({

        template: _.template(require('text!tpl/dialogs/add.html')),

        className: 'addDialog',

        initialize: function() {
            var view = this;
            $('body').one('click', function(){
                view.remove();
            });
            this.$el.on('click', function(){
                return false;
            });
        },

        events: {
            "click .closeBtn": "close",
            "click .shareBtn": "share"
        },

        render: function () {
            //render product view
            this.$el.html(this.template({model: this.model}));

            //return view
            return this;
        },

        close: function() {
            this.remove();
        },

        share: function() {
            var view = this;
            FB.api(
                view.$el.parent().attr('data-action-id'),
                'post',
                {
                    message: $('textarea[name="message"]', view.$el).val()
                },
                function () {
                    view.remove();
                }
            );
        }
    });

});