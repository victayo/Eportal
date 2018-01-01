(function () {
    angular.module('Eportal.Result.Controller', [])
            .controller('ResultController', ['$scope', '$location', 'resultService', function ($scope, $location, resultService) {
                    var property = {};
                    $scope.$on('SUBJECT_CHANGED', function (evt, arg) {
                        property.school = arg.school;
                        property.class = arg.class;
                        property.department = arg.department;
                        property.subject = arg.subject;
                        property.term = arg.term.id;
                        property.session = arg.session.id;
                        resultService.setProperty(property);
                    });
                    $scope.button = 'submit';
                    $scope.submit = function () {
                        $scope.button = 'Loading...';
                        resultService.submit(property)
                                .then(function (response) {
                                    resultService.setResultData(response.result_data);
                                    $location.path('/upload');
                                });

                    };
                }])
            .controller('ResultCreateController', ['$scope', '$location', 'resultService', function ($scope, $location, resultService) {
                    $scope.data = resultService.getResultData();
                    if (!$scope.data.length) {
                        $location.path('/');
                    }
                    $scope.button = 'submit';
                    $scope.assessments = resultService.getAssessment();
//                    $scope.columns = resultData();
                    $scope.columns = [];
                    $scope.height = {value: 300};
                    $scope.submit = function () {
                        $scope.button = 'Loading...';
                        resultService.submitUpload($scope.data)
                                .then(function (response) {
                                    if (response.success) {
                                        $location.path('/');
                                    }
                                });
                    };



                    resultService.getAssessment()
                            .then(function (response) {
                                var assessments = response.assessments;
                                $scope.columns.push({data: 'student_name', title: 'Students', readOnly: true});
                                $scope.columns.push({data: 'student_username', title: 'Registration Number', readOnly: true});
                                for (var i = 0, l = assessments.length; i < l; i++) {
                                    var a = assessments[i].id;
                                    $scope.columns.push({data: 'assessment_' + a, title: assessments[i].name, type: 'numeric', readOnly: true});
                                }
                            });
                }]);
})();


