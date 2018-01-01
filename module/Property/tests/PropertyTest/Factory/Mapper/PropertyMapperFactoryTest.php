<?php

namespace PropertyTest\Factory\Mapper;

use Property\Factory\Mapper\PropertyMapperFactory;
use PropertyTest\Bootstrap;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Description of PropertyMapperFactory
 *
 * @author imaleo
 */
class PropertyMapperFactoryTest extends \PHPUnit_Framework_TestCase {

    public function testCreateService() {
        $serviceManager = Bootstrap::getServiceManager();
        $adapter = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
                ->disableOriginalConstructor()
                ->getMock();
        $serviceManager->setAllowOverride(TRUE);
        $serviceManager->setService('Zend\Db\Adapter\Adapter', $adapter);
        $serviceManager->setService('Property\Hydrator\Property', new ClassMethods(false));
        $factory = new PropertyMapperFactory();
        $result = $factory->createService($serviceManager);
        $this->assertInstanceOf('Property\Mapper\PropertyMapper', $result);
    }

}
