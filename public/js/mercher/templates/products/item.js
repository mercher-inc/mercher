Mercher.Templates.Products.Item = _.template(
        '<td>' +
            '<a href="/products/<%- model.id %>.html">' +
                '<%- model.get(\'brand\') %> <%- model.get(\'title\') %>' +
            '</a>' +
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
                '<button class="btn btn-default like" data-loading-text="Liking..." data-liked-text="Liked">Like</button>' +
                '<button class="btn btn-default update">Edit</button>' +
                '<button class="btn btn-danger delete">Delete</button>' +
            '</div>' +
        '</td>'
);