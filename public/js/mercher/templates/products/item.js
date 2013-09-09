Mercher.Templates.Products.Item = _.template(
        '<td>' +
            '<%- model.get(\'brand\') %>' +
        '</td>' +
        '<td>' +
            '<a href="/products/<%- model.id %>.html"><%- model.get(\'title\') %></a>' +
            '<% if (model.get(\'plural_title\')) { %>' +
                ' <i>(<%- model.get(\'plural_title\') %>)</i>' +
            '<% } %>' +
        '</td>' +
        '<td>' +
            '<%- model.get(\'price\') %>' +
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