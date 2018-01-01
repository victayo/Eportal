angular.module('Eportal.User.Controller', [])
        .controller('RegisterController', ['$scope', 'userService', function ($scope, userService) {
                $scope.property = {};
                $scope.user = {};
                $scope.$watch('user', function (newValue) {
                    userService.setUsers(newValue);
                }, true);
            }])
        .controller('ListController', ['$scope', '$location', 'userService', function ($scope, $location, userService) {
//                $scope.users = [];

                var property_name;
                var properties;
                $scope.$on('PROPERTY_CHANGED', function (event, data) {
                    property_name = data.active_property.name;
                    properties = data.all_property;
                });

                $scope.getUsers = function ($event) {
                    $event.preventDefault();
                    switch (property_name) {
                        case 'school':
                            if (!properties.session || !properties.term || !properties.school) {
                                return;
                            }
                            userService.getSchoolUsers(properties.session.id, properties.term.id, properties.school)
                                    .then(function (response) {
                                        if (response.success) {
                                            $scope.$broadcast('USERS', response.users);
                                        }
                                    });
                            break;
                        case 'class':
                            if (!properties.session || !properties.term || !properties.school || !properties.class) {
                                return;
                            }
                            userService.getClassUsers(properties.session.id, properties.term.id, properties.school, properties.class)
                                    .then(function (response) {
                                        if (response.success) {
                                            $scope.$broadcast('USERS', response.users);
                                        }
                                    });
                            break;
                        case 'department':
                            if (!properties.session || !properties.term || !properties.school || !properties.class || !properties.department) {
                                return;
                            }
                            userService.getDepartmentUsers(properties.session.id, properties.term.id, properties.school, properties.class, properties.department)
                                    .then(function (response) {
                                        if (response.success) {
                                            $scope.$broadcast('USERS', response.users);
                                        }
                                    });
                            break;
                        case 'subject':
                            if (!properties.session || !properties.term || !properties.school || !properties.class || !properties.department || !properties.subject) {
                                return;
                            }
                            userService.getSubjectUsers(properties.session.id, properties.term.id, properties.school, properties.class, properties.department, properties.subject)
                                    .then(function (response) {
                                        if (response.success) {
                                            $scope.$broadcast('USERS', response.users);
                                        }
                                    });
                            break;
                    }
                    $location.path('/student');
                };
            }])
        .controller('StudentController', ['$scope', 'userService', function ($scope, userService) {
                $scope.users = [];
                $scope.userEmpty = false;
                $scope.$on('USERS', function (event, data) {
                    console.log(data);
                    $scope.users = data;
                    $scope.userEmpty = data.length<1;
                })
//                $scope.editUser = function (user) {
//                    console.log(user);
//                }
            }])


