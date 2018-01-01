<?php

namespace PropertyTest\Factory\Mapper;

use Property\Factory\Mapper\PropertyValueMapperFactory;
use PropertyTest\Bootstrap;

/**
 * Description of PropertyValueMapperTest
 *
 * @author imaleo
 */
class PropertyValueMapperTest extends \PHPUnit_Framework_TestCase{
    
    public function testCreateService() {
        $serviceManager = Bootstrap::getServiceManager();
        $adapter = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
                ->disableOriginalConstructor()
                ->getMock();
//        $hydrator = $this->getMockBuilder('Property\Mapper\Hydrator\PropertyValueHydrator')
//                ->disableOriginalConstructor()
//                ->getMock();
        $serviceManager->setAllowOverride(TRUE);
        $serviceManager->setService('Zend\Db\Adapter\Adapter', $adapter);
//        $serviceManager->setService('Property\Hydrator\PropertyValue', $hydrator);
        $factory = new PropertyValueMapperFactory();
        $result = $factory->createService($serviceManager);
        $this->assertInstanceOf('Property\Mapper\PropertyValueMapper', $result);
    }
}
