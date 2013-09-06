Mercher.Views.Pages.Item = Backbone.View.extend({
    tagName: "tr",
    attributes: {class: 'pages-item'},
    template: Mercher.Templates.Pages.Item,
    events: {
        "click .add_shop": "addShop"
    },
    initialize: function () {
        this.listenTo(this.model, "change", this.render);
        this.listenTo(this.model, "remove", this.remove);
    },
    render: function () {
        this.$el.html(this.template({model: this.model}));
        return this;
    },
    addShop: function () {
        var self = this;
        FB.getLoginStatus(function (response) {
            FB.api(
                '/' + self.model.id + '/tabs',
                'post',
                {
                    access_token: self.model.get('access_token'),
                    app_id: fb_app_id
                },
                function (response) {
                    if (response) {
                        self.model.collection.fetch();
                        FB.api(
                            '/' + self.model.id + '/tabs/app_' + fb_app_id,
                            'post',
                            {
                                access_token: self.model.get('access_token'),
                                position: 2,
                                custom_name: 'Shop'
                            }
                        );
                    }
                }
            );
        });
    }
});