define(function (require, exports, module) {

    "use strict";

    var Backbone = require('backbone'),
        UniqueModel = require('backbone.uniquemodel'),
        LikesCollection = require('og/actions/collections/likes'),
        AddsCollection = require('og/actions/collections/adds');

    return UniqueModel(
        Backbone.Model.extend({
            urlRoot: module.config().urlRoot,
            initialize: function (options) {
                this.likes = new LikesCollection([], {object: this.get('fb_id')});
                this.adds = new AddsCollection([], {object: this.get('fb_id')});
            }
        })
    );

});