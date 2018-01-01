(function () {
    angular.module('Eportal.Result.Controller', [])
            .controller('ResultController', ['$scope', 'resultService', function ($scope, resultService) {
                    $scope.columns = [];
                    $scope.data = [];
                    $scope.session = '';
                    $scope.term = '';
                    resultService.getResultData()
                            .then(function (response) {
                                $scope.data = response.result_data;
                                $scope.session = response.session.value;
                                $scope.term = response.term.value;
                            });
                    resultService.getAssessment()
                            .then(function (response) {
                                var assessments = response.assessments;
                                $scope.columns.push({data: 'subject_name', title: 'Subject', readOnly: true});
                                for (var i = 0, l = assessments.length; i < l; i++) {
                                    var a = assessments[i].id;
                                    $scope.columns.push({data: 'assessment_' + a, title: assessments[i].name, type: 'numeric', readOnly: true});
                                }
                            });
                }]);
})();


