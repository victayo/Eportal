<?php
namespace Property\Mapper\Hydrator;

use Property\Mapper\Hydrator\RelPropertyValueHydrator;
use Property\Model\Property;
use Property\Model\PropertyValue;
use Property\Model\RelPropertyValue;

class JointPropertyValueHydratorTest extends \PHPUnit_Framework_TestCase
{
    private $hydrator;
    private $service;
    private $firstPropertyValue;
    private $secondPropertyValue;
    public function setUp()
    {
        parent::setUp();
        $this->service = $this->getMockBuilder('Property\Service\PropertyValueService')
        ->disableOriginalConstructor()
        ->getMock();
        $this->hydrator = new RelPropertyValueHydrator($this->service);
        $this->firstPropertyValue = new PropertyValue(1, 'property_value_1', new Property(1, 'property_1'));
        $this->secondPropertyValue = new PropertyValue(2, 'property_value_2', new Property(2, 'property_2'));
    }
    
    public function testHydrate() {
        $object = new RelPropertyValue();
        $data = array(
            'id' => 1,
            'first_property_value' => $this->firstPropertyValue->getId(),
            'second_property_value' => $this->secondPropertyValue->getId(),
        );
        $this->service->expects($this->any())->method('findById')
                ->will($this->onConsecutiveCalls($this->firstPropertyValue, $this->secondPropertyValue));
        $jpv = $this->hydrator->hydrate($data, $object);
//        \Zend\Debug\Debug::dump($jpv);
        $this->assertNotNull($jpv);
        $this->assertSame($this->firstPropertyValue, $jpv->getFirstPropertyValue());
        $this->assertSame($this->secondPropertyValue, $jpv->getSecondPropertyValue());
    }
    
    public function testExtract(){
        $object = new RelPropertyValue(1, $this->firstPropertyValue, $this->secondPropertyValue);
        $data = $this->hydrator->extract($object);
        $this->assertEquals($data['id'], $object->getId());
        $this->assertEquals($data['first_property_value'], $this->firstPropertyValue->getId());
        $this->assertEquals($data['second_property_value'], $this->secondPropertyValue->getId());
    }
}

