angular.module('Eportal.Property.Controller', []);
(function () {
    function PropertyController($rootScope, $scope, propertyService) {
        $scope.property = {};
        $scope.collections = {};
        $scope.hasDepartment = false;
        $scope.hasSubject = false;
        $scope.user_template = '/eportal/module/userproperty/partials/users.html';

        propertyService.initialize()
                .then(function (response) {
                    $scope.collections.sessions = response.sessions;
                    $scope.collections.terms = response.terms;
                    $scope.collections.schools = response.schools;
                    $scope.property.term = getValue(response.active_term, $scope.collections.terms);
                    $scope.property.session = getValue(response.active_session, $scope.collections.sessions);
                });

        function getValue(id, collection) {
            for (var i = 0; i < collection.length; i++) {
                if (collection[i].id == id) {
                    return collection[i];
                }
            }
            return null;
        }
        $scope.sessionChanged = function () {
            $scope.property.term = '';
            $scope.collections.terms = [];
            propertyService.setProperty($scope.property);
            changeBroadcast('session');

            propertyService.getTerms($scope.property.session)
                    .then(function (response) {
                        if (response.success) {
                            $scope.collections.terms = response.terms;
                        }
                    });
            $scope.property.session = getValue($scope.property.session, $scope.collections.sessions);
        };

        $scope.termChanged = function () {
            propertyService.setProperty($scope.property);
            propertyService.setActiveProperty($scope.property.term);
            changeBroadcast('term');
        };

        $scope.schoolChanged = function () {
            $scope.property.class = '';
            $scope.hasDepartment = false;
            $scope.hasSubject = false;
            $scope.property.department = '';
            $scope.property.subject = '';
            $scope.collections.departments = [];
            $scope.collections.subjects = [];
            propertyService.setProperty($scope.property);
            propertyService.setActiveProperty($scope.property.school);
            changeBroadcast('school');
            if (!$scope.property.school) {
                return;
            }
            if ($('#property_class').length) {
                propertyService.School.getClass($scope.property.school)
                        .then(function(response){
                            $scope.collections.classes = response;
                });
            }
            $rootScope.$broadcast('SCHOOL_CHANGED', $scope.property);
        };
        $scope.classChanged = function () {
            $scope.property.department = '';
            $scope.property.subject = '';
            propertyService.setProperty($scope.property);
            propertyService.setActiveProperty($scope.property.class);
            $scope.hasDepartment = false;
            $scope.hasSubject = false;
            changeBroadcast('class');
            if (!$scope.property.class || !$scope.property.school) {
                return;
            }
            if ($('#property_department').length) {
                propertyService.getDepartments($scope.property.school, $scope.property.class)
                        .then(function (response) {
                            if (response.success) {
                                $scope.collections.departments = response.departments;
                                $scope.hasDepartment = response.departments.length > 0;
                            }
                        });
            }
            if ($('#property_subject').length) {
                propertyService.getSubjects($scope.property.school, $scope.property.class)
                        .then(function (response) {
                            if (response.success) {
                                $scope.collections.subjects = response.subjects;
                                $scope.hasSubject = response.subjects.length > 0;
                            }
                        });
            }
            $rootScope.$broadcast('CLASS_CHANGED', $scope.property);
        };

        $scope.departmentChanged = function () {
            $scope.property.subject = '';
            $scope.collections.subjects = [];
            $scope.hasSubject = false;
            propertyService.setActiveProperty($scope.property.department);
            propertyService.setProperty($scope.property);
            changeBroadcast('department');
            if (!$scope.property.department || !$scope.property.class || !$scope.property.school) {
                return;
            }
            if ($('#property_subject').length) {
                propertyService.getSubjects($scope.property.school, $scope.property.class, $scope.property.department)
                        .then(function (response) {
                            if (response.success) {
                                $scope.collections.subjects = response.subjects;
                                $scope.hasSubject = response.subjects.length > 0;
                            }
                        });
            }
            $rootScope.$broadcast('DEPARTMENT_CHANGED', $scope.property);
        };

        $scope.subjectChanged = function () {
            propertyService.setProperty($scope.property);
            propertyService.setActiveProperty($scope.property.subject);
            changeBroadcast('subject');
            if (!$scope.property.subject || !$scope.property.class || !$scope.property.school) {
                return;
            }
            $rootScope.$broadcast('SUBJECT_CHANGED', $scope.property);
        };

        function changeBroadcast(name) {
            if (!name) {
                $rootScope.$broadcast('PROPERTY_CHANGED', {});
                return;
            }
            var data = {
                all_property: $scope.property,
                active_property: {
                    id: $scope.property[name],
                    name: name
                }
            };
            $rootScope.$broadcast('PROPERTY_CHANGED', data);
        }
    }
    PropertyController.$inject = ['$rootScope', '$scope', 'propertyService'];
    angular.module('Eportal.Property.Controller').controller('PropertyController', PropertyController);
}());


