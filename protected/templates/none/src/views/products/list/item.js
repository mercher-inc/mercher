define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        Bootstrap = require('bootstrap'),
        tpl = require('text!app/tpl/products/list/item.html'),
        template = _.template(tpl);

    return Backbone.View.extend({

        className: 'col-sm-3',

        initialize: function () {
            this.listenTo(this.model, "sync", this.render);
        },

        events: {
            "click .likeProduct": "likeProduct",
            "click .dislikeProduct": "dislikeProduct"
        },

        render: function () {
            this.$el.html(template({model: this.model}));
            this.checkLike();
            return this;
        },

        checkLike: function() {
            var view = this;
            var $button = $('.likeProduct', this.$el);
            $button.button('loading');
            FB.api(
                'me/og.likes?object=' + this.model.get('fb_id'),
                {
                    object: this.model.get('fb_id')
                },
                function(response) {
                    $button.button('reset');
                    if (response && response.data && response.data.length) {
                        $button.attr('data-like-id', response.data[0].id);
                        $button.html('Dislike');
                        $button.toggleClass('likeProduct').toggleClass('dislikeProduct');
                        view.getLikes();
                    }
                }
            );
        },

        likeProduct: function (event) {
            var view = this;
            var $button = $('.likeProduct', this.$el);
            $button.button('loading');
            FB.api(
                'me/og.likes',
                'post',
                {
                    object: this.model.get('fb_id')
                },
                function(response) {
                    $button.button('reset');
                    $button.attr('data-like-id', response.id);
                    $button.html('Dislike');
                    $button.toggleClass('likeProduct').toggleClass('dislikeProduct');
                    view.getLikes();
                }
            );
            return this;
        },

        dislikeProduct: function (event) {
            var view = this;
            var $button = $('.dislikeProduct', this.$el);
            $button.button('loading');
            FB.api(
                $button.attr('data-like-id'),
                'delete',
                function() {
                    $button.button('reset');
                    $button.removeAttr('data-like-id');
                    $button.html('Like');
                    $button.toggleClass('dislikeProduct').toggleClass('likeProduct');
                    view.getLikes();
                }
            );

            return this;
        },

        getLikes: function() {
            var $button = $('.likeProduct, .dislikeProduct', this.$el);
            FB.api(
                this.model.get('fb_id') + '/likes?summary=1',
                {
                    object: this.model.get('fb_id')
                },
                function(response) {
                    if (response && response.summary && response.summary.total_count) {
                        $button.append(' (' + response.summary.total_count + ')');
                    }
                }
            );
        }

    });

});