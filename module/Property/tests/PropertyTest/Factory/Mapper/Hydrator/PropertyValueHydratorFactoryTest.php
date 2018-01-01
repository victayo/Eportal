<?php


namespace PropertyTest\Factory\Mapper\Hydrator;

use Property\Factory\Mapper\Hydrator\PropertyValueHydratorFactory;
use PropertyTest\Bootstrap;
/**
 * Description of PropertyValueHydratorFactoryTest
 *
 * @author imaleo
 */
class PropertyValueHydratorFactoryTest extends \PHPUnit_Framework_TestCase {
    public function testCreateService() {
        $serviceManager = Bootstrap::getServiceManager();
        $propertyService = $this->getMockBuilder('Property\Service\PropertyService')
                ->disableOriginalConstructor()
                ->getMock();
        $serviceManager->setAllowOverride(TRUE);
        $serviceManager->setService('Property\Service\Property', $propertyService);
        $factory = new PropertyValueHydratorFactory();
        $result = $factory->createService($serviceManager);
        
        $this->assertInstanceOf('Property\Mapper\Hydrator\PropertyValueHydrator', $result);
    }
}
