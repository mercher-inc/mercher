Mercher.Templates.Pages.Item = _.template(
        '<td>' +
            '<img src="//graph.facebook.com/<%- model.get(\'id\') %>/picture" class="img-circle" style="height: 50px; width: 50px;" />' +
        '</td>' +
        '<td>' +
            '<%- model.get(\'name\') %>' +
        '</td>' +
        '<td>' +
            '<%- model.get(\'description\') %>' +
        '</td>' +
        '<td>' +
            '<%- model.get(\'category\') %>' +
        '</td>' +
        '<td>' +
            '<div class="btn-group pull-right" style="white-space: nowrap;">' +
                '<% if (model.get(\'has_added_app\')) { %>' +
                    '<a class="btn btn-default" href="//www.facebook.com/<%- model.get(\'id\') %>?sk=app_<%- fb_app_id %>" target="_blank">View shop</a>' +
                '<% } else { %>' +
                    '<button class="btn btn-success add_shop">Add tab</button>' +
                '<% } %>' +
                '<a class="btn btn-default" href="/shops/<%- model.get(\'id\') %>.html">Edit shop</a>' +
            '</div>' +
        '</td>'
);