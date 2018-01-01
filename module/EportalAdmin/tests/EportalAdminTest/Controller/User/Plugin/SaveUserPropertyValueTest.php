<?php

namespace EportalAdminTest\Controller\User\Plugin;

use EportalAdmin\Controller\User\Plugin\SaveUserPropertyValue;
use EportalAdminTest\Controller\User\AbstractUserControllerTestCase;
use EportalProperty\Model\EportalProperty;
use EportalUser\Form\Model\Property;
use EportalUser\Model\EportalUser;

/**
 *
 * @author imaleo
 */
class SaveUserPropertyValueTest extends AbstractUserControllerTestCase{
    protected $controller;
    protected $plugin;
    public function setUp() {
        parent::setUp();
        $controller = $this->getMockBuilder('EportalAdmin\Controller\User\StudentController')
                ->setMethods(null)
                ->getMock();
        $this->init(true);
        $controller->setServiceLocator($this->serviceManager);
        $this->plugin = new SaveUserPropertyValue();
        $this->plugin->setController($controller);
    }
    
    public function testSave(){
        $user = new EportalUser();
        $user->setFirstName('okala')
                ->setLastName('tayo')
                ->setEmail('email@awesome.com');
//        $property = new Property();
        $property = new EportalProperty();
        $property->setClass(1)
                ->setSession(2)
                ->setTerm(3)
                ->setDepartment(4);
        $result = $this->plugin->save($user, $property);
        $this->assertFalse($result);
    }
    
}
