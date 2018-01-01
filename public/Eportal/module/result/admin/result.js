(function () {
    angular.module('Eportal.Result', [
        'Eportal.Result.Controller',
        'Eportal.Result.Service',
        'Eportal.Property.Controller',
        'Eportal.Property.Service',
        'Eportal.Property.Directive',
        'ngRoute',
        'ngHandsontable'
    ]).config(function ($routeProvider, $locationProvider) {
        $locationProvider.hashPrefix('');
        $routeProvider.when('/', {
            controller: 'ResultController',
            templateUrl: '/eportal/module/result/admin/partials/index.html'
        }).when('/upload', {
            controller: 'ResultCreateController',
            templateUrl: '/eportal/module/result/admin/partials/upload.html'
        });
    });
})();



