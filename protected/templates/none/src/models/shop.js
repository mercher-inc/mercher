define(function (require) {

    "use strict";

    var Backbone = require('backbone');

    return Backbone.Model.extend({
        urlRoot: function () {
            return '/api/shops/';
        }
    });

});