<?php

namespace PropertyTest\Service;

use Property\Model\Property;
use Property\Service\PropertyService;
/**
 * Description of PropertyServiceTest
 *
 * @author imaleo
 */

class PropertyServiceTest extends \PHPUnit_Framework_TestCase{
    /**
     *
     * @var Property\Mapper\PropertyMapper
     */
    private $mapper;
    private $service;
    
    public function setUp(){
        parent::setUp();
        $this->mapper = $this->getMockBuilder('Property\Mapper\PropertyMapper')
                ->getMock();
        $this->service = new PropertyService($this->mapper);
    }
    
    public function testFindByIdAndName() {
        $property = new Property(1, 'property');
        $this->mapper->expects($this->once())
                ->method('findById')
                ->will($this->returnValue($property));
        $this->mapper->expects($this->once())
                ->method('findByName')
                ->will($this->returnValue($property));
        $result = $this->service->findById(1);
        $nameRes = $this->service->findByName('name');
        $this->assertSame($result, $property);
        $this->assertSame($nameRes, $property);
    }
}
