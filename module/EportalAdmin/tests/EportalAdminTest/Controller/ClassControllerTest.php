<?php

namespace EportalAdminTest\Controller;

use Property\Model\Property;
use Property\Model\PropertyValue;

/**
 *
 * @author imaleo
 */
class ClassControllerTest extends AbstractPropertyControllerTestCase{
    protected $traceError = true;
    protected $propertyValueService;
    protected $propertyService;
    protected $classForm;
    protected $jpvService;
    
    public function setUp() {
        parent::setUp();
        $this->classForm = $this->getMockBuilder('EportalAdmin\Form\ClassForm')
                ->disableOriginalConstructor()
                ->getMock();
        $serviceManager = $this->getServiceManager();
        $serviceManager->setService('EportalAdmin\Form\ClassForm', $this->classForm);
    }
    
    public function testIndexActionCanBeAccessed() {
        $property = new Property(1, 'class');
        $this->propertyService->expects($this->any())
                ->method('findByName')
                ->will($this->returnValue($property));

        $this->propertyValueService->expects($this->any())
                ->method('findByProperty')
                ->will($this->returnValue(array()));
        $this->dispatch('/admin/class');
        $this->assertResponseStatusCode(200);
        $this->assertControllerClass('ClassController');
        $this->assertActionName('index');
    }
    
    public function testIndexActionCanBeAccessedWithQueryParams() {
        $this->jpvService->expects($this->once())
                ->method('getSubject')
                ->will($this->returnValue(array()));
        $this->jpvService->expects($this->once())
                ->method('getSection')
                ->will($this->returnValue(array()));
        $this->jpvService->expects($this->once())
                ->method('getSchool')
                ->will($this->returnValue(array()));
        $this->propertyValueService->expects($this->once())
                ->method('findById')
                ->will($this->returnValue(new PropertyValue()));
        $this->dispatch('/admin/class?pid=2');
        $this->assertResponseStatusCode(200);
}
}