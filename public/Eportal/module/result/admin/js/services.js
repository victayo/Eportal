(function () {
    angular.module('Eportal.Result.Service', [])
            .factory('resultService', ['$http', function ($http) {
                    var url = '/admin/result/upload/edit';
                    var $property;
                    var $assessments = [];
                    var $resultData = [];
                    var submit = function (property) {
                        return $http.post(url, property)
                                .then(function (response) {
                                    return response.data;
                                });
                    };
                    return{
                        submit: submit,
                        submitUpload: function (data) {
                            var uploadUrl = '/admin/result/upload/submit';
                            var uploadData = {
                                property: $property,
                                result_data: data
                            };
                            return $http.post(uploadUrl, uploadData).then(function (response) {
                                return response.data;
                            });
                        },
//                        setAssessment: function (assessment) {
//                            $assessments = assessment;
//                        },
                        getAssessment: function () {
//                            if (!$assessments) {
                                return $http.get('/admin/result/assessment?json=1')
                                        .then(function (response) {
                                            return response.data;
                                        });
//                            } else {
//                                return $assessments;
//                            }
                        },
                        getProperty: function () {
                            return $property;
                        },
                        setProperty: function (property) {
                            $property = property;
                        },
                        getResultData: function () {
                            return $resultData;
                        },
                        setResultData: function (resultData) {
                            $resultData = resultData;
                        }
                    };
                }]);
})();


