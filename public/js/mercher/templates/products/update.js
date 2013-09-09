Mercher.Templates.Products.Update = _.template(
        '<div class="modal-dialog">' +
            '<div class="modal-content">' +
                '<div class="modal-header">' +
                    '<h4 class="modal-title">Update product</h4>' +
                '</div>' +
                '<div class="modal-body">' +
                    '<form>'+
                        '<div class="form-group <%- (typeof validation_errors !== "undefined" && typeof validation_errors.brand !== "undefined")?\'has-error\':\'\' %>">'+
                            '<label class="control-label" for="inputBrand">Brand</label>'+
                            '<input type="text" class="form-control" id="inputBrand" name="brand" placeholder="Brand" value="<%- (typeof userValues !== "undefined" && typeof userValues.brand !== "undefined")?userValues.brand:model.get(\'brand\') %>">'+
                            '<% if (typeof validation_errors !== "undefined" && typeof validation_errors.brand !== "undefined") { %>' +
                                '<p class="help-block"><%= validation_errors.brand %></p>' +
                            '<% } %>'+
                        '</div>'+
                        '<div class="form-group <%- (typeof validation_errors !== "undefined" && typeof validation_errors.title !== "undefined")?\'has-error\':\'\' %>">'+
                            '<label class="control-label" for="inputTitle">Title</label>'+
                            '<input type="text" class="form-control" id="inputTitle" name="title" placeholder="Title" value="<%- (typeof userValues !== "undefined" && typeof userValues.title !== "undefined")?userValues.title:model.get(\'title\') %>">'+
                            '<% if (typeof validation_errors !== "undefined" && typeof validation_errors.title !== "undefined") { %>' +
                                '<p class="help-block"><%= validation_errors.title %></p>' +
                            '<% } %>'+
                        '</div>'+
                        '<div class="form-group <%- (typeof validation_errors !== "undefined" && typeof validation_errors.price !== "undefined")?\'has-error\':\'\' %>">'+
                            '<label class="control-label" for="inputPrice">Price</label>'+
                            '<input type="text" class="form-control" id="inputPrice" name="price" placeholder="Price" value="<%- (typeof userValues !== "undefined" && typeof userValues.price !== "undefined")?userValues.price:model.get(\'price\') %>">'+
                            '<% if (typeof validation_errors !== "undefined" && typeof validation_errors.price !== "undefined") { %>' +
                                '<p class="help-block"><%= validation_errors.price %></p>' +
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
                    '<button class="btn btn-primary save">Save changes</button>' +
                '</div>' +
            '</div>' +
        '</div>'
);