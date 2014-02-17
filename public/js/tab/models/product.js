define(function (require, exports, module) {

    "use strict";

    var Backbone = require('backbone'),
        LikesCollection = require('og/actions/collections/likes'),
        AddsCollection = require('og/actions/collections/adds');

    return Backbone.Model.extend({
        urlRoot: module.config().urlRoot,
        initialize: function (options) {
            this.likes =  new LikesCollection([], {object: this.get('fb_id')});
            this.adds =  new AddsCollection([], {object: this.get('fb_id')});
        }
    });

});