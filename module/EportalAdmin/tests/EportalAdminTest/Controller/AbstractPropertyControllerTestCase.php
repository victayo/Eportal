<?php

namespace EportalAdminTest\Controller;

use Property\Model\PropertyValue;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 *
 * @author imaleo
 */
abstract class AbstractPropertyControllerTestCase extends AbstractHttpControllerTestCase{
    protected $traceError = true;
    protected $propertyValueService;
    protected $propertyService;
    protected $serviceManager;
    protected $jpvService;
    
    public function setUp() {
        $this->setApplicationConfig(include 'C:/xampp/htdocs/Eportal/config/application.config.php');
        parent::setUp();
        
        $this->propertyValueService = $this->getMockBuilder('Property\Service\PropertyValueService')
                ->disableOriginalConstructor()
                ->getMock();
        $this->propertyService = $this->getMockBuilder('Property\Service\PropertyService')
                ->disableOriginalConstructor()
                ->getMock();
        $this->jpvService = $this->getMockBuilder('EportalAdmin\Service\EportalJointPropertyValueService')
                ->disableOriginalConstructor()
                ->getMock();
        $this->serviceManager = $this->getApplicationServiceLocator();
        $this->serviceManager->setAllowOverride(TRUE);
        $this->serviceManager->setService('Property\Service\Property', $this->propertyService);
        $this->serviceManager->setService('Property\Service\PropertyValue', $this->propertyValueService);
        $this->serviceManager->setService('EportalAdmin\Service\EportalJointPropertyValue', $this->jpvService);
    }
    
    public function getPropertyValues($property, $qty = 10) {
        $propertyValues = [];
        for($i = 1; $i <= $qty; $i++) {
            $propertyValues[] = new PropertyValue($i, 'pv_'.$i, $property);
        }
        return $propertyValues;
    }
    
    public function getPropertyValueService() {
        return $this->propertyValueService;
    }

    public function getPropertyService() {
        return $this->propertyService;
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function getJointPropertyValueService() {
        return $this->jpvService;
    }
}
