beforeEach(module('Eportal.Property.Service'));
beforeEach(module('Eportal.Property.Controller'));

describe('Property Controller', function(){
    it('is initialized', inject(function($rootScope, $controller, propertyService){
        var $scope = $rootScope.$new();
        var controller = $controller('PropertyController', {$rootScope: $rootScope, $scope: $scope, propertyService: propertyService});
        expect(controller).toBeDefined();
    }));
})


