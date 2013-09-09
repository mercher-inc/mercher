Mercher.Templates.Categories.Item = _.template(
        '<td>' +
            '<a href="/categories/<%- model.id %>.html"><%- model.get(\'title\') %></a>' +
        '</td>' +
        '<td>' +
            '<%- model.get(\'description\') %>' +
        '</td>' +
        '<td>' +
            '<div class="btn-group pull-right" style="white-space: nowrap;">' +
                '<button class="btn btn-default">Edit</button>' +
                '<button class="btn btn-danger">Delete</button>' +
            '</div>' +
        '</td>'
);