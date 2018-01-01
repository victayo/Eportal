<?php


namespace PropertyTest\Factory\Mapper;

use Property\Factory\Mapper\AbstractRelPropertyValueMapperFactory;
use PropertyTest\Bootstrap;

/**
 * Description of JointPropertyValueMapperFactoryTest
 *
 * @author imaleo
 */
class JointPropertyValueMapperFactoryTest extends \PHPUnit_Framework_TestCase{
    
    public function testCreateService() {
        $serviceManager = Bootstrap::getServiceManager();
        $adapter = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
                ->disableOriginalConstructor()
                ->getMock();
//        $hydrator = $this->getMockBuilder('Property\Mapper\Hydrator\JointPropertyValueHydrator')
//                ->disableOriginalConstructor()
//                ->getMock();
        $serviceManager->setAllowOverride(TRUE);
        $serviceManager->setService('Zend\Db\Adapter\Adapter', $adapter);
//        $serviceManager->setService('Property\Hydrator\JointPropertyValue', $hydrator);
        $factory = new AbstractRelPropertyValueMapperFactory();
        $result = $factory->createService($serviceManager);
        $this->assertInstanceOf('Property\Mapper\JointPropertyValueMapper', $result);
    }
}
