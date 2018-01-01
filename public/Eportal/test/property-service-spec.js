(function () {
    beforeEach(module('Eportal.Property.Service'));
    var $httpBackend;
    var propertyService;
    var url = '/admin';
    beforeEach(inject(function (_$httpBackend_, _propertyService_) {
        $httpBackend = _$httpBackend_;
        propertyService = _propertyService_;
    }));
    
    describe('Property Service', function () {
        it('should be initialized', function () {
            expect(propertyService).toBeDefined();
        });
    });
    
    describe('getSchool()', function () {
        var schoolUrl = url + '/school?json=1';
        var schools = [
            {id: 1, value: 'SSS'},
            {id: 2, value: 'JSS'}
        ];
        it('should getSchool()', function () {
            $httpBackend.expectGET(schoolUrl).respond(schools);
            var schs = propertyService.getSchools();
            $httpBackend.flush();
            expect(schs.$$state.value.length).toEqual(schools.length);
        });
    });
}());
