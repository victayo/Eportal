<?php

namespace EportalAdminTest\Controller\User;

use EportalAdmin\Controller\User\StudentController;
use Property\Model\Property;
use Property\Model\PropertyValue;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

/**
 *
 * @author imaleo
 */
class StudentControllerTest extends AbstractUserControllerTestCase {

    protected $controller;
    protected $routeMatch;
    protected $event;
    protected $request;
    protected $response;
    protected $ejpvService;
    protected $jpvService;
    protected $pvService;

    public function setUp() {
        parent::setUp();
        $this->controller = new StudentController();
        $this->routeMatch = new RouteMatch(array('controller' => 'school'));
        $this->request = new Request();
        $this->response = new Response();
        $this->event = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
    }

    protected function getControllerMock($methodsToMock){
        $controller = $this->getMockBuilder('EportalAdmin\Controller\User\StudentController')
                ->setMethods($methodsToMock)
                ->getMock();
        $controller->setEvent($this->event);
        return $controller;
    }
    
    public function testIndexAction() {
        $this->dispatch('/admin/user/student');
        $this->assertResponseStatusCode(200);
    }

    public function testProcessActionWithMockedServices() {
        $this->init();
        $content = array('id' => 5);
        $departments = $this->getPropertyValuesArray('department');
        $sections = $this->getPropertyValuesArray('section');
        $this->getPropertyValueService()->expects($this->once())
                ->method('findById')
                ->will($this->returnValue(new PropertyValue()));
        $this->getEportalJointPropertyValueService()->expects($this->once())
                ->method('getDepartment')
                ->will($this->returnValue($departments));
        $this->getEportalJointPropertyValueService()->expects($this->once())
                ->method('getSection')
                ->will($this->returnValue($sections));
        $form = $this->getMockBuilder('EportalUser\Form\UserRegistrationForm')
                ->setMethods(null)
                ->getMock();
        $this->serviceManager->setService('EportalUser\Form\Registration', $form);
        $request = $this->getRequest();
        $request->setContent($content);
        $this->dispatch('/admin/user/student/process', 'GET', array(), true);
        $this->assertResponseStatusCode(200);
        $response = $this->getResponse();
        $variables = json_decode($response->getContent(), true);
//        var_dump($variables['departments']);
        $this->assertTrue($variables['success']);
        $this->assertEquals(count($variables['departments']), count($departments));
        $this->assertEquals(count($variables['sections']), count($sections));
        
        
    }

    public function testProcessActionRedirectsWhenXmlHttpRequest(){
        $content = array('id' => 5);
        $this->dispatch('/admin/user/student/process', 'GET', $content, false);
        $this->assertResponseStatusCode(302);
    }
    
    public function testProcessActionWithRealServices(){
        $this->init(true);
        $pvService = $this->getPropertyValueService();
        $class = $this->getPropertyService()->findByName('class');
        $classes = $pvService->findByProperty($class);
        $cls = $classes->current();
        $content = array('id' => $cls->getId());
        $request = $this->getRequest();
        $request->setContent($content);
        $this->dispatch('/admin/user/student/process', 'GET', array(), true);
        $this->assertResponseStatusCode(200);
        $response = $this->getResponse();
        $variables = json_decode($response->getContent(), true);
        $this->assertTrue($variables['success']);
    }
    
    public function testRegisterActionWithMockedServices() {
        $this->init();
        $post = array(
            'register' => array(
                'user' => array(
                    'first_name' => 'First Name',
                    'middle_name' => 'Middle Name',
                    'last_name' => 'Last Name',
                    'username' => 'Username',
                    'dob' => '2012-10-5',
                    'gender' => 2
                ),
                'property' => array(
                    'class' => 1,
                    'section' => 1,
                    'department' => 1,
                    'session' => 1,
                    'term' => 1
                )
        ));

        $param = $this->getMockBuilder('Zend\Stdlib\Parameters')
                ->setConstructorArgs(array($post))
                ->setMethods(null)
                ->getMock();

        $form = $this->getMockBuilder('EportalUser\Form\UserRegistrationForm')
                ->setMethods(null)
                ->getMock();
        $this->setFormvalueOptions($form);
        $this->setForm($form);
        $plugin = $this->getMock('EportalAdmin\Controller\User\Plugin\SaveUserPropertyValue');
        $plugin->expects($this->once())
                ->method('save')
                ->will($this->returnValue(true));
        
        $this->controller->getPluginManager()->setService('SaveUserPropertyValue', $plugin);
        $this->controller->setForm($form);
        $this->controller->setServiceLocator($this->serviceManager);
        $this->routeMatch->setParam('action', 'register');
        $this->request->setMethod('POST');
        $this->request->setPost($param);
        
        $response = $this->controller->dispatch($this->request);
        $variables = $response->getVariables();
        $this->assertTrue($variables['success']);

        $this->dispatch('/admin/user/student/register', 'POST', $post);
        $this->assertResponseStatusCode(200);
    }

    protected function getPropertyValuesArray($property, $qty = 5) {
        $propertyValues = [];
        for ($i = 0; $i < $qty; $i++) {
            $prop = new Property($i + 1, $property);
            $propertyValue = new PropertyValue(($i + 1) * 2, 'value_' . $i, $prop);
            $propertyValues[] = $propertyValue;
        }
        return $propertyValues;
    }

    private function setFormvalueOptions($form) {
        $form->remove('csrf');
        $fieldset = $form->get('register')->get('property');
        $fieldset->get('class')->setValueOptions(array(1 => 'one'));
        $fieldset->get('section')->setValueOptions(array(1 => 'one'));
        $fieldset->get('session')->setValueOptions(array(1 => 'one'));
        $fieldset->get('term')->setValueOptions(array(1 => 'one'));
        $fieldset->get('department')->setValueOptions(array(1 => 'one'));
    }

}
