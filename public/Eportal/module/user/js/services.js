angular.module('Eportal.User.Service', [])
        .factory('userService', ['$http', function ($http) {
                var users = [];
                var propertyData;
                var url = '/admin/user/list';

                return {
                    setUsers: function ($user) {
                        users = $user;
                    },
                    getUsers: function () {
                        return users;
                    },
                    getSchoolUsers: function (session, term, school) {
                        var query = url + '?sesid=' + session + '&tid=' + term + '&schid=' + school + '&property=school';
                        return $http.get(query)
                                .then(function (response) {
                                    return response.data;
                                });
                    },
                    getClassUsers: function (session, term, school, class_id) {
                        var query = url + '?sesid=' + session + '&tid=' + term + '&schid=' + school + '&cid=' + class_id + '&property=class';
                        return $http.get(query)
                                .then(function (response) {
                                    return response.data;
                                });
                    },
                    getDepartmentUsers: function (session, term, school, class_id, department) {
                        var query = url + '?sesid=' + session + '&tid=' + term + '&schid=' + school + '&cid=' + class_id + '&did=' + department + '&property=department';
                        return $http.get(query)
                                .then(function (response) {
                                    return response.data;
                                });
                    },
                    getSubjectUsers: function (session, term, school, class_id, department, subject) {
                        var query = url + '?sesid=' + session + '&tid=' + term + '&schid=' + school + '&cid=' + class_id + '&did=' + department + '&subid=' + subject + '&property=subject';
                        return $http.get(query)
                                .then(function (response) {
                                    return response.data;
                                });
                    },
                    getPropertyData: function(){
                        return propertyData;
                    },
                    setPropertyData: function(pd){
                        propertyData = pd;
                    }
                };
            }])


