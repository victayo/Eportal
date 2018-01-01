(function () {
    angular.module('Eportal.Property.Directive', [])
            .directive('property', function () {
                var allProperties = ['session', 'term', 'school', 'class', 'department', 'subject'];
                return {
                    restrict: 'AE',
                    controller: 'PropertyController',
                    scope: true,
                    templateUrl: '/eportal/module/property/partials/property_fieldset.html',
                    link: function (scope, element, attr) {
                        scope.render = {};
                        var properties = attr.property;
                        if(properties.toLowerCase() === 'all'){
                            properties = allProperties;
                        }else{
                            properties = properties.split(' ');
                        }
                        for (var i = 0, l = properties.length; i < l; i++) {
                            scope.render[properties[i]] = true;
                        }
                    }
                };
            });
})();

