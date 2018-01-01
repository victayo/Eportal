<?php

namespace PropertyTest\Mapper;

use Property\Mapper\PropertyValueMapper;
use Property\Model\Property;
use Property\Model\PropertyValue;

/**
 * Description of PropertyValueMapperTest
 *
 * @author imaleo
 */
class PropertyValueMapperTest extends AbstractPropertyMapperTest {
    /**
     *
     * @var PropertyValueMapper
     */
    protected $mapper;
    protected $hydrator;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp();
        $this->hydrator = $this->getMockBuilder('Property\Mapper\Hydrator\PropertyValueHydrator')
                ->disableOriginalConstructor()
                ->getMock();
        $this->mapper = new PropertyValueMapper();
        $this->mapper->setEntityPrototype(new PropertyValue())
                ->setDbAdapter($this->getAdapter())
                ->setHydrator($this->hydrator);
        $this->loadPropertyValueTable();
    }

    public function testFindById() {
        $propertyValues = $this->getPropertyValues();
        $id = rand(1, count($propertyValues));
        $pv = explode(',', $propertyValues[$id - 1]);
        $property = new Property($pv[0]);
        $propertyValue = new PropertyValue($id, $pv[1], $property);
        
        $this->hydrator->expects($this->once())
                ->method('hydrate')
                ->will($this->returnValue($propertyValue));
        $result = $this->mapper->findById($id);
        $this->assertNotNull($result);
        $this->assertInstanceOf('Property\Model\PropertyValueInterface', $result);
        $this->assertSame($result, $propertyValue);
    }

    public function testInsert() {
        $property = new Property(23, 'property');
        $propertyValue = new PropertyValue(null, 'property_value', $property);
        $entityArr = array(
            'value' => $propertyValue->getValue(),
            'property' => $propertyValue->getProperty()->getId()
        );
        $this->hydrator->expects($this->any())
                ->method('extract')
                ->will($this->returnValue($entityArr));
        $this->mapper->insert($propertyValue);
        $this->assertNotNull($propertyValue->getId());
        $this->assertGreaterThanOrEqual(1, $propertyValue->getId());
    }

    /**
     * 
     */
    public function testUpdates() {
        $propertyValues = $this->getPropertyValues();
        $id = rand(1, count($propertyValues));
        $pv = explode(',', $propertyValues[$id - 1]);
        $property = new Property($pv[0]);
        $propertyValue = new PropertyValue($id, $pv[1], $property);
        $update = new PropertyValue($id, 'update_property_value', $propertyValue->getProperty());
        
        $this->hydrator->expects($this->any())
                ->method('hydrate')
                ->will($this->returnValue($update));
        $updateArr = array(
            'id' => $update->getId(),
            'value' => $update->getValue(),
            'property' => $update->getProperty()->getId()
        );
        $this->hydrator->expects($this->any())
                ->method('extract')
                ->will($this->returnValue($updateArr));
        $this->mapper->update($update);
        $updatePv = $this->mapper->findById($id);
        
        $this->assertNotEquals($propertyValue->getValue(), $updatePv->getValue());
        $this->assertEquals($updatePv->getValue(), $update->getValue());
        $this->assertEquals($updatePv->getId(), $update->getId());
    }

}
