<?php

namespace PropertyTest\Service;

use Property\Model\Property;
use Property\Model\PropertyValue;
use Property\Service\RelPropertyValueService;

/**
 * Description of JointPropertyValueMapperTest
 *
 * @author imaleo
 */
class JointPropertyValueServiceTest extends \PHPUnit_Framework_TestCase{
    private $mapper;
    private $service;
    
    public function setUp() {
        $this->mapper = $this->getMockBuilder('Property\Mapper\JointPropertyValueMapper')
                ->disableOriginalConstructor()
                ->getMock();
        $this->service = new RelPropertyValueService($this->mapper);
    }
    
    public function testFindByFirstPropertyValue() {
        $returnValue = array();
        $propertyValue = new PropertyValue();
        $this->mapper->expects($this->once())
                ->method('findByFirstPropertyValue')
                ->will($this->returnValue($returnValue));
        $result = $this->service->findByParent($propertyValue);
        $this->assertEquals($returnValue, $result);
    }
    
    public function testFindFirstPropertyValue() {
        $returnValue = array();
        $propertyValue = new PropertyValue();
        $this->mapper->expects($this->once())
                ->method('findFirstPropertyValue')
                ->will($this->returnValue($returnValue));
        $result = $this->service->findParent(new Property(), $propertyValue);
        $this->assertEquals($returnValue, $result);
    }
    
    public function testFindSecondPropertyValue() {
        $returnValue = array();
        $propertyValue = new PropertyValue();
        $this->mapper->expects($this->once())
                ->method('findSecondPropertyValue')
                ->will($this->returnValue($returnValue));
        $result = $this->service->findChildPropertyValue(new Property(), $propertyValue);
        $this->assertEquals($returnValue, $result);
    }
    
    public function testFindJointPropertyValue() {
        $returnValue = array();
        $propertyValue = new PropertyValue();
        $this->mapper->expects($this->once())
                ->method('findJointPropertyValue')
                ->will($this->returnValue($returnValue));
        $result = $this->service->findRelPropertyValue($propertyValue, $propertyValue);
        $this->assertEquals($returnValue, $result);
    }
    
    public function testFindById() {
        $returnValue = new \Property\Model\RelPropertyValue();
        $this->mapper->expects($this->once())
                ->method('findById')
                ->will($this->returnValue($returnValue));
        $result = $this->service->findById(1);
        $this->assertEquals($returnValue, $result);
    }
}
