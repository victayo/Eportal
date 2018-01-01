<?php

namespace EportalAdminTest\Controller\User;

use EportalAdminTest\Controller\AbstractControllerTestCase;

/**
 *
 * @author imaleo
 */
abstract class AbstractUserControllerTestCase extends AbstractControllerTestCase
{
    protected $upv;
    protected $ujpv;
    protected $userService;
    protected $form;
    
    public function setUp() {
        parent::setUp();
    }

    protected function init($useRealServiceLocator = false) {
        parent::init($useRealServiceLocator);
        if(!$useRealServiceLocator){
            $this->serviceManager->setService('EportalUser\Service\UserPropertyValue', $this->getUserPropertyValueService());
        $this->serviceManager->setService('EportalUser\Service\UserJointPropertyValue', $this->getUserJointPropertyValueService());
        $this->serviceManager->setService('EportalUser\Service\EportalUser', $this->getEportalUserService());
        $this->serviceManager->setService('EportalUser\Form\Registration', $this->getForm());
        }
    }

    public function getUserPropertyValueService() {
        if($this->useRealServiceLocator){
            $this->upv = $this->serviceManager->get('EportalUser\Service\UserPropertyValue');
            return $this->upv;
        }
        if(!$this->upv){
            $this->upv = $this->getMockBuilder('EportalUser\Service\UserPropertyValueService')
                ->disableOriginalConstructor()
                ->getMock();
        }
        return $this->upv;
    }

    public function setUserPropertyValueService($service){
        $this->upv = $service;
        $this->serviceManager->setService('EportalUser\Service\UserPropertyValue', $this->getUserPropertyValueService());
        return $this;
    }
    
    public function getUserJointPropertyValueService() {
        if($this->useRealServiceLocator){
            $this->ujpv = $this->serviceManager->get('EportalUser\Service\UserJointPropertyValue');
            return $this->ujpv;
        }
        if(!$this->ujpv){
            $this->ujpv = $this->getMockBuilder('EportalUser\Service\UserJointPropertyValueService')
                ->disableOriginalConstructor()
                ->getMock();
        }
        return $this->ujpv;
    }

    public function setUserJointPropertyValueService($service) {
        $this->ujpv = $service;
        $this->serviceManager->setService('EportalUser\Service\UserJointPropertyValue', $this->getUserJointPropertyValueService());
        return $this;
    }
    
    public function getEportalUserService() {
        if($this->useRealServiceLocator){
            $this->userService = $this->serviceManager->get('EportalUser\Service\EportalUser');
            return $this->userService;
        }
        if(!$this->userService){
            $this->userService = $this->getMockBuilder('EportalUser\Service\EportalUserService')
                ->disableOriginalConstructor()
                ->getMock();
        }
        return $this->userService;
    }
    
    public function setEportalUserService($service){
        $this->userService = $service;
        $this->serviceManager->setService('EportalUser\Service\EportalUser', $this->getEportalUserService());
        return $this;
    }


    public function getForm(){
        if($this->useRealServiceLocator){
            $this->form = $this->serviceManager->get('EportalUser\Form\Registration');
            return $this->form;
        }
        if(!$this->form){
            $this->form = $this->getMockBuilder('EportalUser\Form\UserRegistrationForm')
                    ->disableOriginalConstructor()
                    ->getMock();
        }
        return $this->form;
    }
    
    public function setForm($form){
        $this->form = $form;
    }
}
