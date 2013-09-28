define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        Bootstrap = require('bootstrap'),
        tpl = require('text!app/tpl/products/list/item.html'),
        template = _.template(tpl);

    return Backbone.View.extend({

        className: 'col-sm-' + Math.round(12 / Math.sqrt(appConfig.perPageCount)),

        initialize: function () {
            this.listenTo(this.model, "sync", this.render);
        },

        events: {
            "click .likeProduct": "likeProduct"
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
                function(response) {
                    if (response && response.data && response.data.length) {
                        $button.attr('data-like-id', response.data[0].id);
                        $button.addClass('active');
                    } else {
                        $button.removeClass('active');
                    }
                    $button.button('reset');
                    view.getLikes();
                }
            );
        },

        likeProduct: function (event) {
            var view = this;
            var $button = $('.likeProduct', this.$el);
            $button.button('loading');
            if ($button.hasClass('active')) {
                FB.api(
                    $button.attr('data-like-id'),
                    'delete',
                    function() {
                        $button.button('reset');
                        $button.removeAttr('data-like-id');
                        $button.removeClass('active');
                        view.getLikes();
                    }
                );
            } else {
                FB.api(
                    'me/og.likes',
                    'post',
                    {
                        object: view.model.get('fb_id')
                    },
                    function(response) {
                        $button.button('reset');
                        $button.attr('data-like-id', response.id);
                        $button.addClass('active');
                        view.getLikes();
                    }
                );
            }

            return this;
        },

        getLikes: function() {
            var $button = $('.likeProduct, .dislikeProduct', this.$el);
            $button.button('loading');
            FB.api(
                this.model.get('fb_id') + '/likes?summary=1',
                function(response) {
                    $button.button('reset');
                    if (response && response.summary && response.summary.total_count) {
                        $button.html(response.summary.total_count);
                    } else {
                        $button.html(0);
                    }
                }
            );
        }

    });

});