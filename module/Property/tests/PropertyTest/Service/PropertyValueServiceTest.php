<?php

namespace PropertyTest\Service;

use Property\Model\Property;
use Property\Model\PropertyValue;
use Property\Service\PropertyValueService;

/**
 * Description of PropertyValueServiceTest
 *
 * @author imaleo
 */
class PropertyValueServiceTest extends \PHPUnit_Framework_TestCase {
    private $mapper;
    private $propertyValueService;
    
    public function setUp() {
        $this->mapper = $this->getMockBuilder('Property\Mapper\PropertyValueMapperInterface')
                ->disableOriginalConstructor()
                ->getMock();
        $this->propertyValueService = new PropertyValueService($this->mapper);
    }
    
    public function testFindByPropertyAndIdAndAll(){
        $property = new Property(1, 'property');
        $propertyValue = new PropertyValue(1, 'property_value', $property);
        $this->mapper->expects($this->once())
                ->method('findById')
                ->will($this->returnValue($propertyValue));
        $this->mapper->expects($this->once())
                ->method('findByProperty')
                ->will($this->returnValue(array()));
        $this->mapper->expects($this->once())
                ->method('findAll')
                ->will($this->returnValue(array()));
        $idResult = $this->propertyValueService->findById(1);
        $this->assertEquals($idResult->getId(), $propertyValue->getId());
        $propResult = $this->propertyValueService->findByProperty($property);
        $this->assertTrue(is_array($propResult));
        $allResult = $this->propertyValueService->findAll();
        $this->assertTrue(is_array($allResult));
    }
}
