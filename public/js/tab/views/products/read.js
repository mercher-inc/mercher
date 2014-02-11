define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Backbone = require('backbone');

    return Backbone.View.extend({

        template: _.template(require('text!templates/products/read.html')),
        tagName: 'section',
        className: 'page index-index',

        events: {

        },

        initialize: function (options) {

        }

    });

});