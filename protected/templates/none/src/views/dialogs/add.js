define(function (require) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Backbone = require('backbone');

    return Backbone.View.extend({

        template: _.template(require('text!tpl/dialogs/add.html')),

        className: 'dialog dialog-add',

        events: {
            "click .addBtn": "addProduct"
        },

        render: function () {

            //append to content block
            this.$el.appendTo('body');
            $("#backdrop").show();

            //render product view
            this.$el.html(this.template({model: this.model}));

            //return view
            return this;
        },

        addProduct: function() {
            var view = this;

            var obj = {
                product: view.model.get('fb_id'),
                "fb:explicitly_shared" : $('input[name="share"]', this.$el).is(':checked')
            };
            if ($('textarea[name="message"]', this.$el).val()) {
                obj.message = $('textarea[name="message"]', this.$el).val();
            }
            FB.api(
                'me/mercher:add',
                'post',
                obj,
                function(response){
                    if (typeof response.id != 'undefined') {
                        require(['ga'], function (ga) {
                            ga(
                                'send',
                                'social',
                                'facebook',
                                'add',
                                'products/' + view.model.id
                            );
                        });
                    }
                }
            );
            view.remove();
            $("#backdrop").hide();
        }
    });

});