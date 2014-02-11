define(function (require, exports, module) {

    FB.init({
        appId: module.config().appId,
        logging: true,
        status: true,
        cookie: true,
        xfbml: true
    });
    FB._namespace = module.config().namespace;
    return FB;

});