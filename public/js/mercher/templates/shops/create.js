Mercher.Templates.Shops.Create = _.template(
        '<div class="modal-dialog">' +
            '<div class="modal-content">' +
                '<div class="modal-header">' +
                    '<h4 class="modal-title">Create new shop</h4>' +
                '</div>' +
                '<div class="modal-body">' +
                    '<form>'+
                        '<div class="form-group <%- (typeof validation_errors !== "undefined" && typeof validation_errors.title !== "undefined")?\'has-error\':\'\' %>">'+
                            '<label class="control-label" for="inputTitle">Title</label>'+
                            '<input type="text" class="form-control" id="inputTitle" name="title" placeholder="Title" value="<%- (typeof userValues !== "undefined" && typeof userValues.title !== "undefined")?userValues.title:model.get(\'title\') %>">'+
                            '<% if (typeof validation_errors !== "undefined" && typeof validation_errors.title !== "undefined") { %>' +
                                '<p class="help-block"><%= validation_errors.title %></p>' +
                            '<% } %>'+
                        '</div>'+
                        '<div class="form-group <%- (typeof validation_errors !== "undefined" && typeof validation_errors.description !== "undefined")?\'has-error\':\'\' %>">'+
                            '<label class="control-label" for="inputDescription">Description</label>'+
                            '<textarea class="form-control" id="inputDescription" name="description" placeholder="Description"><%= (typeof userValues !== "undefined" && typeof userValues.description !== "undefined")?userValues.description:model.get(\'description\') %></textarea>'+
                            '<% if (typeof validation_errors !== "undefined" && typeof validation_errors.description !== "undefined") { %>' +
                                '<p class="help-block"><%= validation_errors.description %></p>' +
                            '<% } %>'+
                        '</div>'+
                    '</form>'+
                '</div>' +
                '<div class="modal-footer">' +
                    '<button class="btn btn-default cancel">Close</button>' +
                    '<button class="btn btn-primary create">Create</button>' +
                '</div>' +
            '</div>' +
        '</div>'
);