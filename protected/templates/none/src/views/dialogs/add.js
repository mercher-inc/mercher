define(function (require) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Backbone = require('backbone');

    return Backbone.View.extend({

        template: _.template(require('text!tpl/dialogs/add.html')),

        className: 'addDialog',

        initialize: function () {
            var view = this;
            $('body').one('click', function () {
                view.close();
            });
            this.$el.on('click', function () {
                return false;
            });
        },

        events: {
            "click .closeBtn": "close",
            "click .addImplicitlyBtn": "addImplicitly",
            "click .addExplicitlyBtn": "addExplicitlyBtn"
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

        addImplicitly: function () {
            var object = {
                product: this.model.get('fb_id'),
                "fb:explicitly_shared": false
            };
            var message = $('textarea[name="message"]', this.$el).val();
            if (message) {
                object.message = message;
            }
            this._send(object);
        },

        addExplicitlyBtn: function () {
            var object = {
                product: this.model.get('fb_id'),
                "fb:explicitly_shared": true
            };
            var message = $('textarea[name="message"]', this.$el).val();
            if (message) {
                object.message = message;
            }
            this._send(object);
        },

        _send: function (object) {
            var view = this;
            FB.api(
                'me/' + FB._namespace + ':add',
                'post',
                object,
                function (response) {
                    if (response.id) {
                        view.$el.parent().attr('data-action-id', response.id);
                        view.$el.parent().addClass('active');
                    }
                    view.close();
                }
            );
        }
    });

});