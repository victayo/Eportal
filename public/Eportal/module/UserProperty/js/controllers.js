angular.module('Eportal.UserProperty.Controller', ['Eportal.Property.Controller', 'ngRoute', 'ngDialog'])
        .config(function ($routeProvider, $locationProvider) {
            $locationProvider.hashPrefix('');
            $routeProvider.when('/student', {
                templateUrl: '/Eportal/module/UserProperty/partials/student.html'
            }).when('/teacher', {
                templateUrl: '/Eportal/module/UserProperty/partials/teacher.html'
            });
        })
        .controller('UserController', ['$scope', '$location', 'ngDialog', 'userService', 'propertyService', function ($scope, $location, ngDialog, userService, propertyService) {
                $scope.users = [];
                $scope.userEmpty;
                $scope.view = false;
                $scope.action = {};
                $scope.action.selectAction = '';

                $scope.$on('PROPERTY_CHANGED', function () {
                    $scope.view = false;
                    $scope.users = [];
                });


                $scope.getUsers = function (role) {
                    var property = propertyService.getProperty();
                    userService.getPropertyUsers(property, role)
                            .then(function (response) {
                                if (response.success) {
                                    $scope.users = response.users;
                                    $scope.userEmpty = $scope.users.length === 0;
                                    $scope.view = true;
                                    userService.setActiveRole(role);
                                    $location.path('/' + role);
                                }
                            });
                };

                $scope.editUser = function (user) {
                    userService.setUser(user);
                    ngDialog.open({
                        template: '/Eportal/module/UserProperty/partials/edit_form.html',
                        controller: 'UserEditController',
                        height: 'auto'
                    });
                };


                $scope.getEditUrl = function (user) {
                    var editUrl = '/admin/user/edit?uid=' + user.id;
                    return editUrl;
                };

                $scope.removeUser = function (user) {
                    console.log(user);
                    console.log(propertyService.getActiveProperty());
                };
                $scope.getViewUrl = function (user) {
                    var property = propertyService.getProperty();
                    var url = '/admin/user/list/single?';
                    var query = 'uid=' + user.id + '&session=' + property.session + '&term=' + property.term;
                    return url + query;
                };
                $scope.bulkAction = function () {
                    if (!$scope.action.selectAction) {
                        return;
                    }
                    var selectedUsers = [];
                    angular.forEach($scope.users, function (user) {
                        if (user.selected) {
                            selectedUsers.push(user);
                        }
                    });
                    switch ($scope.action.selectAction) {
                        case 'promote':
                            console.log(selectedUsers);
                            break;
                        case 'graduate':
                            console.log(selectedUsers);
                            break;
                        case 'delete':
                            console.log(selectedUsers);
                            break;
                        case 'suspend':
                            console.log(selectedUsers);
                            break;
                        case 'expel':
                            console.log(selectedUsers);
                            break;
                        default:
                            return;
                    }
                };
            }])
        .controller('UserEditController', ['$scope', '$route', 'ngDialog', 'userService', 'propertyService', function ($scope, $route, ngDialog, userService, propertyService) {
                $scope.user = userService.getUser();
                $scope.message = '';
                $scope.editSubmit = function () {
                    if ($scope.editForm.$valid) {
                        userService.editUser($scope.user)
                                .then(function (response) {
                                    if (response.success) {
                                        if (response.valid) {
                                            $scope.message = 'Successful!';
                                            userService.getPropertyUsers(propertyService.getProperty(), userService.getActiveRole);
                                            $scope.user = {};
//                                            $route.reload();
//                                            ngDialog.close();
                                        } else {
                                            $scope.message = 'Failed';
                                        }
                                    }
                                });
                    } else {
                        $scope.message = 'Invalid Input';
                    }
                };
            }])
        .controller('UserRegisterController', ['$scope', '$window', 'userService', 'propertyService', function ($scope, $window, userService, propertyService) {
//                $scope.property = [];
//                $scope.success;
                $scope.property = {};
                $scope.user = {};
                $scope.$watch('user', function (newValue) {
                    userService.setUser(newValue);
                }, true);

                $scope.submit = function (event) {
                    event.preventDefault();

                    if ($scope.form.$valid) {
                        var data = {
                            register: {
                                property: propertyService.getProperty(),
                                user: userService.getUser()
                            }
                        };
                        var url = $window.location.pathname;
                        userService.registerUser(url, data)
                                .then(function (response) {
                                    if (response.success) {
                                        if (response.valid) {
                                            clear();
                                            $window.alert('User Successfully Added');
                                        }
                                    }
                                });
                    }
                };
                function clear() {
                    console.log($scope.property);
                    $scope.user = {};
                    userService.setUser($scope.user);
                    var property = propertyService.getProperty();
                    var session = property.session;
                    var term = property.term;

                    $scope.property.session = session;
                    $scope.property.term = term;
                    console.log($scope.property);
                    propertyService.setProperty($scope.property);
                }
            }])
        .controller('SubjectUserController', ['$scope', 'userService', function ($scope, userService) {
                $scope.$on('PROPERTY_CHANGED', listener);
                function listener(event, data) {
                    var propertyName = data.active_property.name;
                    var allProperty = data.all_property;
                    if(allow(propertyName, allProperty[propertyName])){
                        userService.getPropertyUsers(allProperty, 'teacher')
                                    .then(function (response) {
                                        if(response.success){
                                            console.log(response.users);
                                        }
                                    });
                    }
                    
                    function allow(propertyName, propertyValue){
                        if(propertyName === 'class' || propertyName === 'section' || propertyName === 'subject'){
                            if(!propertyValue){
                                return false;
                            }
                            return true;
                        };
                        return false;
                    }
                }
            }])


