angular.module('Eportal.UserProperty.Service', ['Eportal.Property.Service'])
        .factory('userService', ['$http', function ($http) {
                var user = {};
                var activeRole;
                var getUsers = function (property, role) {
                    var data = {
                        session: property.session,
                        term: property.term,
                        property: {}
                    };
                    if(role !== undefined){
                        data.role = role;
                    }
                    if (property.school) {
                        data.property.school = property.school;
                    }
                    if (property.class) {
                        data.property.class = property.class;
                    }
                    if (property.department) {
                        data.property.department = property.department;
                    }
                    if (property.section) {
                        data.property.section = property.section;
                    }
                    return $http.post('/admin/user/property', data)
                            .then(function (response) {
                                return response.data;
                            });
                };
                var edit = function (user) {
                    var editUrl = '/admin/user/edit';
                    return $http.post(editUrl + '?ajax=1&uid=' + user.id, {user: user})
                            .then(function (response) {
                                return response.data;
                            });
                };
                var register = function(url, userData){
                    return $http.post(url, userData)
                            .then(function (response) {
                                return response.data;
                            });
                };
                
                return {
                    getPropertyUsers: getUsers,
                    getUser : function(){
                        return user;
                    },
                    setUser: function(newUser){
                        user = newUser;
                    },
                    editUser: edit,
                    registerUser: register,
                    getActiveRole: function(){
                        return activeRole;
                    },
                    setActiveRole: function(active){
                        activeRole = active;
                    }
                };
            }]);


