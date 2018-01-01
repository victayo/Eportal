<?php
namespace Property\Mapper\Hydrator;

use Property\Mapper\Hydrator\PropertyValueHydrator;
use Property\Model\PropertyValue;
use Property\Model\Property;

class PropertyValueHydratorTest extends \PHPUnit_Framework_TestCase
{
    private $hydrator;
    private $propertyService;
    
    public function setUp(){
        parent::setUp();
        $this->propertyService = $this->getMockBuilder('Property\Service\PropertyService')
        ->disableOriginalConstructor()
        ->getMock();
        $this->hydrator = new PropertyValueHydrator($this->propertyService);
    }
    
    public function testHydrate(){
        $object = new PropertyValue();
        $data = array(
            'id' => 1,
            'value' => 'property_value',
            'property' => 1
        );
        $property = new Property($data['property'], 'property_1');
        
        $this->propertyService->expects($this->once())
        ->method('findById')
        ->with($data['property'])
        ->will($this->returnValue($property));
        
        $result = $this->hydrator->hydrate($data, $object);

        $this->assertInstanceOf('Property\Model\PropertyValueInterface', $result);
        $this->assertEquals($result->getId(), $object->getId());
        $this->assertInstanceOf('Property\Model\PropertyInterface', $result->getProperty());
        $this->assertEquals($property->getId(), $result->getProperty()->getId());
        $this->assertEquals($property->getName(), $result->getProperty()->getName());
    }
    
    public function testExtract(){
        $object = new PropertyValue(1, 'property_value', new Property(1, 'property'));
        $result = $this->hydrator->extract($object);
        $this->assertTrue(is_array($result));
        $this->assertEquals($result['property'], $object->getProperty()->getId());
        
        
    }
}

