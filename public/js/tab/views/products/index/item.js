define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager');

    return Layout.extend({

        template: _.template(require('text!templates/products/index/item.html')),
        tagName: 'section',
        className: 'view products-index-item',

        events: {
            "click .buyBtn": 'onBuyBtnClick',
            "click .likeBtn": 'onLikeBtnClick',
            "click .addBtn": 'onAddBtnClick'
        },

        initialize: function (options) {
            var view = this;

            this.listenTo(this.model, 'remove', function (model, collection, options) {
                this.remove();
            });

            require(['fb'], function (FB) {
                FB.Event.subscribe('auth.statusChange', function () {
                    view.model.likes.fetch();
                    view.model.adds.fetch();
                });
            });

            this.listenTo(this.model.likes, 'add remove', function(model, collection, options){
                if (collection.length) {
                    this.$(".likeBtn").addClass('active');
                } else {
                    this.$(".likeBtn").removeClass('active');
                }
            });

            this.listenTo(this.model.adds, 'add remove', function(model, collection, options){
                if (collection.length) {
                    this.$(".addBtn").addClass('active');
                } else {
                    this.$(".addBtn").removeClass('active');
                }
            });
        },

        afterRender: function () {
            var view = this;
            require(['fb'], function (FB) {
                FB.getLoginStatus(function (response) {
                    if (response.status === 'connected') {
                        view.model.likes.fetch();
                        view.model.adds.fetch();
                    }
                });
            });
        },

        serialize: function () {
            return { product: this.model };
        },

        onBuyBtnClick: function (e) {
            console.log('onBuyBtnClick');
        },

        onLikeBtnClick: function (e) {
            var view = this;
            this.controller.options.router.authorize({
                scope: ['publish_actions'],
                success: function(){
                    if (view.model.likes.length) {
                        view.model.likes.last().destroy();
                    } else {
                        var likeAction = new (require('og/actions/models/like'))();
                        view.model.likes.add(likeAction);
                        likeAction.save();
                    }
                },
                error: function(){

                }
            });
        },

        onAddBtnClick: function (e) {
            var view = this;
            this.controller.options.router.authorize({
                scope: ['publish_actions'],
                success: function(){
                    if (view.model.adds.length) {
                        view.model.adds.last().destroy();
                    } else {
                        var addAction = new (require('og/actions/models/add'))();
                        view.model.adds.add(addAction);
                        addAction.save();
                    }
                },
                error: function(){

                }
            });
        }

    });

});