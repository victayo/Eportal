(function () {
    angular.module('Eportal.Result.Service', [])
            .factory('resultService', ['$http', function ($http) {
                    return{
                        getAssessment: function () {
                            return $http.get('/admin/result/assessment?json=1')
                                    .then(function(response){
                                        return response.data;
                            });
                        },
                        getResultData: function(){
                            return $http.get('/student/result?json=1')
                                    .then(function(response){
                                        return response.data;
                                    });
                        }
                    };
                }]);
})();


