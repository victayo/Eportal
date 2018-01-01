angular.module('Eportal.User', [
    'Eportal.User.Controller',
    'Eportal.User.Service',
    'Eportal.User.Filter',
    'Eportal.Property.Controller',
    'Eportal.Property.Service',
    'ngRoute'
])
        .config(function ($routeProvider, $locationProvider) {
            $locationProvider.hashPrefix('');
            $routeProvider.when('/student', {
                templateUrl: '/Eportal/module/user/partials/student.html',
                controller: 'StudentController'
            }).when('/teacher', {
                templateUrl: '/Eportal/module/user/partials/teacher.html'
            });
        });


