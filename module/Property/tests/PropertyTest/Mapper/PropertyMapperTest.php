<?php

namespace PropertyTest\Mapper;

/**
 * Description of PropertyMapper
 *
 * @author imaleo
 */

use Property\Mapper\PropertyMapper;
use Property\Model\Property;
use Zend\Stdlib\Hydrator\ClassMethods;

class PropertyMapperTest extends AbstractPropertyMapperTest {

    /**
     *
     * @var PropertyMapper
     */
    private $propertyMapper;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp();
        $this->propertyMapper = new PropertyMapper();
        $this->propertyMapper->setEntityPrototype(new Property())
                ->setHydrator(new ClassMethods());
        $this->loadPropertyTable();
        $this->propertyMapper->setDbAdapter($this->getAdapter());
    }

    /**
     * Tests PropertyMapper->findAll()
     */
    public function testFindAll() {
        $result = $this->propertyMapper->findAll();
        $this->assertGreaterThan(1, $result->count());
    }

    /**
     * Tests PropertyMapper->findById()
     */
    public function testFindById() {
        $properties = $this->getProperties();
        $id = rand(1, count($properties));
        $result = $this->propertyMapper->findById($id);
        $this->assertInstanceOf('Property\Model\PropertyInterface', $result);
        $this->assertEquals($result->getName(), $properties[$id - 1]);
    }

    /**
     * Tests PropertyMapper->findByName()
     */
    public function testFindByName() {
        $properties = $this->getProperties();
        $id = rand(1, count($properties));
        $realName = $properties[$id - 1];
        $result = $this->propertyMapper->findByName($realName);
        $this->assertEquals($id, $result->getId());
    }

    public function testInsertUpdateDelete() {
        $properties = $this->getProperties();
        $count = count($properties);
        $entity = new Property(null, 'new_property');
        $clone = clone $entity;
        //insert
        $this->propertyMapper->insert($entity);
        $this->assertNotNull($entity->getId());
        $this->assertGreaterThanOrEqual($count, $entity->getId());
        //update
        $entity->setName('new_property_name');
        $this->propertyMapper->update($entity);
        $newName = $this->propertyMapper->findById($count + 1)->getName();
        $this->assertNotEquals($clone->getName(), $newName);
        $this->assertEquals($newName, $entity->getName());
        //delete
        $this->propertyMapper->delete(array('id' => $entity->getId()));
        $this->assertFalse($this->propertyMapper->findById($entity->getId()));
        $this->assertFalse($this->propertyMapper->findById($count+1));
    }

}
