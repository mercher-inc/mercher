Mercher.Views.Dlg.New = Backbone.View.extend({
    tagName: "div",
    attributes: {tabindex: -1, role: 'dialog', "aria-hidden": 'true'},
    className: "modal fade",
    template: _.template(''),
    initialize: function () {
        this.$el.appendTo('body');

        this.listenTo(this.model, "invalid", function (model, error) {
            this.$el.html(this.template({model: model, userValues: this.userValues, validation_errors: error.validation_errors}));
        });
    },
    render: function () {
        this.$el.html(this.template({model: this.model}));
        this.$el.modal();
        return this;
    },
    events: {
        "click .close": "closeDlg",
        "click .cancel": "closeDlg",
        "click .create": "createModel",
        "submit form": "createModel"
    },
    closeDlg: function () {
        view = this;
        view.$el.modal('hide');
        view.$el.on('hidden', function () {
            view.remove();
        });
        return false;
    },
    createModel: function (event) {
        var view = this;
        $dialog = view.$el;
        $button = $('.create', $dialog);
        $button.button('loading');
        view.userValues = view.getData(view.$el);
        view.model.save(view.userValues, {
            wait: true,
            success: function (model, response, options) {
                if (typeof view.collection != 'undefined') {
                    view.collection.fetch({data: view.collection.data});
                }
                $button.button('reset');
                $dialog.modal('hide');
                $dialog.on('hidden', function () {
                    view.remove();
                });
            },
            error: function (model, xhr, options) {
                switch (xhr.status) {
                    case 406:
                        var response = JSON.parse(xhr.responseText);
                        if (typeof response.error !== "undefined" && typeof response.error.validation_errors !== "undefined") {
                            view.$el.html(view.template({model: view.model, userValues: view.userValues, validation_errors: response.error.validation_errors}));
                        }
                        break;
                    default:
                        //console.log(xhr.status);
                        break;
                }
                $button.button('reset');
            }
        });
        return false;
    },
    getData: function (context) {
        var unindexed_array = $('form', context).serializeArray();
        var indexed_array = {};
        $.map(unindexed_array, function (n, i) {
            indexed_array[n['name']] = n['value'];
        });
        return indexed_array;
    }
});