<?php

namespace PropertyTest\Factory\Mapper\Hydrator;

use Property\Factory\Mapper\Hydrator\RelPropertyValueHydratorFactory;
use PropertyTest\Bootstrap;

/**
 * Description of JointPropertyValueHydratorFactoryTest
 *
 * @author imaleo
 */
class JointPropertyValueHydratorFactoryTest extends \PHPUnit_Framework_TestCase {
    public function testCreateService() {
        $serviceManager = Bootstrap::getServiceManager();
        $pvService = $this->getMockBuilder('Property\Service\PropertyValueService')
                ->disableOriginalConstructor()
                ->getMock();
        $serviceManager->setAllowOverride(TRUE);
        $serviceManager->setService('Property\Service\PropertyValue', $pvService);
        $factory = new RelPropertyValueHydratorFactory();
        $result = $factory->createService($serviceManager);
        
        $this->assertInstanceOf('Property\Mapper\Hydrator\JointPropertyValueHydrator', $result);
    }
}
