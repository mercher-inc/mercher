define(['facebook'], function () {
    FB.init({
        appId: appConfig.FB.appId
    });
    return FB;
});