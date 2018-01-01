angular.module('Eportal.Property.Service', []);
(function () {
    function propertyService($http) {
        var School = function () {
            var base_url = '/data/school';
            return {
                getSchool: function (id) {
                    var url = !id ? base_url : base_url + '?id=' + id;
                    return $http.get(url)
                            .then(function (response) {
                                return response.data;
                            });
                },
                getClass: function (id) {
                    return $http.get(base_url + '/get-class?school=' + id)
                            .then(function (response) {
                                return response.data;
                            });
                }
            };
        }();

        var ClassService = function () {
            var base_url = '/data/class';
            return {
                getClass: function (id) {
                    var url = !id ? base_url : base_url + '?id=' + id;
                    return $http.get(url)
                            .then(function (response) {
                                return response.data;
                            });
                },
                getDepartment: function (school, _class) {
                    return $http.get(base_url + '/get-department?school=' + school + 'class=' + _class)
                            .then(function (response) {
                                return response.data;
                            });
                },
                getSubject: function (school, _class) {
                    return $http.get(base_url + '/get-subject?school=' + school + 'class=' + _class)
                            .then(function (response) {
                                return response.data;
                            });
                }
            };
        }();

        var DepartmentService = function () {
            var base_url = '/data/department';
            return {
                getDepartment: function (id) {
                    var url = !id ? base_url : base_url + '?id=' + id;
                    return $http.get(url)
                            .then(function (response) {
                                return response.data;
                            });
                },
                getSubject: function (school, _class, department) {
                    return $http.get(base_url + '/get-subject?school=' + school + '&class=' + _class + '&department=' + department)
                            .then(function (response) {
                                return response.data;
                            });
                }
            };
        }();

        var SubjectService = function () {
            var base_url = '/data/subject';
            return {
                getSubject: function (id) {
                    var url = !id ? base_url : base_url + '?id=' + id;
                    return $http.get(url)
                            .then(function (response) {
                                return response.data;
                            });
                }
            };
        }();

        var SessionService = function () {
            var base_url = '/data/session';
            return {
                getSession: function (id) {
                    var url = !id ? base_url : base_url + '?id=' + id;
                    return $http.get(url)
                            .then(function (response) {
                                return response.data;
                            });
                },
                getTerm: function (session) {
                    return $http.get(base_url + '?session=' + session)
                            .then(function (response) {
                                return response.data;
                            });
                }
            };
        }();

        var TermService = function () {
            var base_url = '/data/term';
            return {
                getTerm: function (id) {
                    var url = !id ? base_url : base_url + '?id=' + id;
                    return $http.get(url)
                            .then(function (response) {
                                return response.data;
                            });
                }
            };
        }();

        var Setting = function () {
            var base_url = '/data/setting';
            return {
                activeSession: function () {
                    return $http.get(base_url + '?active_session')
                            .then(function (response) {
                                return response.data;
                            });
                },
                activeTerm: function () {
                    return $http.get(base_url + '?active_term')
                            .then(function (response) {
                                return response.data;
                            });
                }
            };
        }();

        var BASE_URL = '/admin';
        var json = 'json=1';
        var property;
        var activeProperty;
        
        var setProperty = function (prop) {
            property = prop;
        };
        var getProperty = function () {
            return property;
        };
        var setActiveProperty = function (ap) {
            activeProperty = ap;
        };
        var getActiveProperty = function () {
            return activeProperty;
        };
        var getActiveSession = function () {
            return $http.get(BASE_URL + '/session?active=1')
                    .then(function (response) {
                        return response.data;
                    });
        };
        var getActiveTerm = function () {
            return $http.get(BASE_URL + '/term?active=1')
                    .then(function (response) {
                        return response.data;
                    });
        };
        var getSessions = function () {
            return $http.get(BASE_URL + '/session?' + json)
                    .then(function (response) {
                        return response.data;
                    });
        };
        var getTerms = function (sessionId) {
            return $http.get(BASE_URL + '/session?pid=' + sessionId + '&' + json)
                    .then(function (response) {
                        return response.data;
                    });
        };
        var getSchools = function () {
            return $http.get(BASE_URL + '/school?' + json)
                    .then(function (response) {
                        return response.data;
                    });
        };
        var getClasses = function (schoolId) {
            return $http.get('/data/school/get-class?school=' + schoolId)
                    .then(function (response) {
                        return response.data;
                    });
        };
        var getDepartments = function (school, class_id) {
            return $http.get(BASE_URL + '/class?sid=' + school + '&pid=' + class_id + '&property=department&' + json)
                    .then(function (response) {
                        return response.data;
                    });
        };
        var getSubjects = function (school, class_id, department) {
            var path;
            if (undefined === department) {
                path = '/class?sid=' + school + '&pid=' + class_id + '&property=subject&' + json;
            } else {
                path = '/department?sid=' + school + '&cid=' + class_id + '&pid=' + department + '&' + json;
            }
            return $http.get(BASE_URL + path)
                    .then(function (response) {
                        return response.data;
                    });
        };
        var getActiveSessionTerm = function () {
            return $http.get(BASE_URL + '/setting/get-active')
                    .then(function (response) {
                        return response.data;
                    });
        };

        return {
            getProperty: getProperty,
            setProperty: setProperty,
            getActiveProperty: getActiveProperty,
            setActiveProperty: setActiveProperty,
            getActiveSession: getActiveSession,
            getActiveTerm: getActiveTerm,
            getSessions: getSessions,
            getTerms: getTerms,
            getSchools: getSchools,
            getClasses: getClasses,
            getDepartments: getDepartments,
            getSubjects: getSubjects,
            getActiveSessionTerm: getActiveSessionTerm,
            initialize: function () {
                return $http.get('/data/property/initialize')
                        .then(function (response) {
                            return response.data;
                        });
            },
            School: School,
            Class: ClassService,
            Department: DepartmentService,
            Subject: SubjectService,
            Session: SessionService,
            Term: TermService
//            departmentService: DepartmentService,
//            classService: ClassService
        };
    }
    propertyService.$inject = ['$http'];
    angular.module('Eportal.Property.Service').factory('propertyService', propertyService)
}())


