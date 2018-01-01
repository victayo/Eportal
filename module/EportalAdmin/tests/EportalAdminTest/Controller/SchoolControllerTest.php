<?php

namespace EportalAdminTest\Controller;

use EportalAdmin\Controller\SchoolController;
use Property\Model\Property;
use Property\Model\PropertyValue;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Description of SchoolControllerTest
 *
 * @author imaleo
 */
class SchoolControllerTest extends AbstractHttpControllerTestCase {

    protected $traceError = true;
    protected $propertyValueService;
    protected $propertyService;
    protected $schoolForm;
    protected $jpvService;
    protected $serviceManager;

    public function setUp() {
        $this->setApplicationConfig(include 'C:/xampp/htdocs/Eportal/config/application.config.php');
        parent::setUp();

        $this->propertyValueService = $this->getMockBuilder('Property\Service\PropertyValueService')
                ->disableOriginalConstructor()
                ->getMock();
        $this->propertyService = $this->getMockBuilder('Property\Service\PropertyService')
                ->disableOriginalConstructor()
                ->getMock();
        $this->schoolForm = $this->getMockBuilder('Property\Form\PropertyValueForm')
                ->disableOriginalConstructor()
                ->setMethods(array('setData', 'getData', 'isValid'))
                ->getMock();
        $this->jpvService = $this->getMockBuilder('EportalAdmin\Service\EportalJointPropertyValueService')
                ->disableOriginalConstructor()
                ->getMock();
        $this->serviceManager = $this->getApplicationServiceLocator();
        $this->serviceManager->setAllowOverride(TRUE);
        $this->serviceManager->setService('Property\Service\Property', $this->propertyService);
        $this->serviceManager->setService('Property\Service\PropertyValue', $this->propertyValueService);
        $this->serviceManager->setService('EportalAdmin\Form\SchoolForm', $this->schoolForm);
        $this->serviceManager->setService('EportalAdmin\Service\EportalJointPropertyValue', $this->jpvService);
        
        $this->controller = new SchoolController();
        $this->controller->setServiceLocator($this->serviceManager);
        $this->routeMatch = new RouteMatch(array('controller' => 'property-value'));
        $this->event = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
    }

    public function testIndexActionCanBeAccessed() {
        $property = new Property(1, 'school');
        $this->propertyService->expects($this->any())
                ->method('findByName')
                ->will($this->returnValue($property));

        $this->propertyValueService->expects($this->any())
                ->method('findByProperty')
                ->with($property)
                ->will($this->returnValue(array()));
        $this->dispatch('/admin/school');
        $this->assertResponseStatusCode(200);
        $this->assertControllerClass('SchoolController');
        $this->assertActionName('index');
    }

    public function testIndexActionCanBeAccessedWithQueryParams() {
        $this->jpvService->expects($this->once())
                ->method('getClass')
                ->will($this->returnValue(array()));
        $this->propertyValueService->expects($this->once())
                ->method('findById')
                ->will($this->returnValue(new PropertyValue()));
        $this->dispatch('/admin/school?pid=2');
        $this->assertResponseStatusCode(200);
    }

    public function testAddActionWithGetMethod() {
        $variable = $this->controller->addAction();
        $request = new Request();
        $request->setMethod('get');
        $this->controller->dispatch($request);
        $this->assertNotNull($variable['form']);
    }

    public function testAddActionWithPostMethod() {
        $property = new Property(1, 'school');
        $propertyValue = new PropertyValue(1, 'property_value', $property);
        $this->propertyService->expects($this->any())
                ->method('findByName')
                ->will($this->returnValue($property));

        $this->schoolForm->expects($this->once())
                ->method('setData')
                ->will($this->returnSelf());
        $this->schoolForm->expects($this->once())
                ->method('isValid')
                ->will($this->returnValue(true));
        $this->schoolForm->expects($this->once())
                ->method('getData')
                ->will($this->returnValue($propertyValue));
        $this->propertyValueService->expects($this->once())
                ->method('insert')
                ->will($this->returnValue(true));
        $this->dispatch('/admin/school/add', 'POST');
        $this->assertRedirectTo('/admin/school');
        $this->assertResponseStatusCode(302);
    }

    public function testAddActionForInvalidFormWithPostMethod() {
        $this->schoolForm->expects($this->once())
                ->method('isValid')
                ->will($this->returnValue(false));
        $this->dispatch('/admin/school/add', 'POST');
        $this->assertResponseStatusCode(200);
    }

    protected function getControllerObject() {
        $controller = new SchoolController();
        $routeMatch = new RouteMatch(array('controller' => 'school'));
        $event = new MvcEvent();
        $event->setRouteMatch($routeMatch);
        $controller->setEvent($event);
        $controller->setSchoolForm($this->schoolForm)
                ->setPropertyValueService($this->propertyValueService)
                ->setPropertyService($this->propertyService)
                ->setEportalRelPropertyValueService($this->jpvService);
        return $controller;
    }

}
