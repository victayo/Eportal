<?php

namespace EportalAdminTest\Controller;

/**
 *
 * @author imaleo
 */
abstract class AbstractControllerTestCase extends \Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase {

    protected $propertyService;
    protected $pvService;
    protected $jpvService;
    protected $ejpvService;
    protected $serviceManager;
    protected $traceError = true;
    protected $useRealServiceLocator = false;

    public function setUp() {
        $this->setApplicationConfig(include 'C:/xampp/htdocs/Eportal/config/application.config.php');
        parent::setUp();
        $this->setTraceError($this->traceError);
    }

    protected function init($useRealServiceLocator = false) {
        $this->useRealServiceLocator = $useRealServiceLocator;
        $this->serviceManager = $this->getApplicationServiceLocator();
        if (!$useRealServiceLocator) {
            $this->serviceManager->setAllowOverride(TRUE);
            $this->serviceManager->setService('Property\Service\PropertyValue', $this->getPropertyValueService());
            $this->serviceManager->setService('EportalAdmin\Service\EportalJointPropertyValue', $this->getEportalJointPropertyValueService());
            $this->serviceManager->setService('Property\Service\Property', $this->getPropertyService());
            $this->serviceManager->setService('Property\Service\JointPropertyValue', $this->getJointPropertyValueService());
        }
    }

    public function getPropertyService() {
        if ($this->useRealServiceLocator) {
            $this->propertyService = $this->serviceManager->get('Property\Service\Property');
            return $this->propertyService;
        }
        if (!$this->propertyService) {
            $this->propertyService = $this->getMockBuilder('Property\Service\PropertyService')
                    ->disableOriginalConstructor()
                    ->getMock();
        }
        return $this->propertyService;
    }

    public function setPropertyService($propertyService) {
        $this->propertyService = $propertyService;
        $this->serviceManager->setService('Property\Service\Property', $this->getPropertyService());
        return $this;
    }

    public function getPropertyValueService() {
        if ($this->useRealServiceLocator) {
            $this->pvService = $this->serviceManager->get('Property\Service\PropertyValue');
            return $this->pvService;
        }
        if (!$this->pvService) {
            $this->pvService = $this->getMockBuilder('Property\Service\PropertyValueService')
                    ->disableOriginalConstructor()
                    ->getMock();
        }
        return $this->pvService;
    }

    public function setPropertyValueService($service) {
        $this->pvService = $service;
        $this->serviceManager->setService('Property\Service\PropertyValue', $this->getPropertyValueService());
        return $this;
    }

    public function getJointPropertyValueService() {
        if ($this->useRealServiceLocator) {
            $this->jpvService = $this->serviceManager->get('Property\Service\JointPropertyValue');
            return $this->jpvService;
        }
        if (!$this->jpvService) {
            $this->jpvService = $this->getMockBuilder('Property\Service\JointPropertyValueService')
                    ->disableOriginalConstructor()
                    ->getMock();
        }
        return $this->jpvService;
    }

    public function setJointPropertyValueService($service) {
        $this->jpvService = $service;
        $this->serviceManager->setService('Property\Service\JointPropertyValue', $this->getJointPropertyValueService());
        return $this;
    }

    public function getEportalJointPropertyValueService() {
        if ($this->useRealServiceLocator) {
            $this->ejpvService = $this->serviceManager->get('EportalAdmin\Service\EportalJointPropertyValue');
            return $this->ejpvService;
        }
        if (!$this->ejpvService) {
            $this->ejpvService = $this->getMockBuilder('EportalAdmin\Service\EportalJointPropertyValueService')
                    ->disableOriginalConstructor()
                    ->getMock();
        }
        return $this->ejpvService;
    }

    public function setEportalJointPropertyValueService($service) {
        $this->ejpvService = $service;
        $this->serviceManager->setService('EportalAdmin\Service\EportalJointPropertyValue', $this->getEportalJointPropertyValueService());
        return $this;
    }

}
