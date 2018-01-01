<?php

namespace Property\Service;

/**
 *
 * @author imaleo
 *        
 */
use Property\Mapper\PropertyMapperInterface;
use Property\Model\PropertyInterface;

class PropertyService implements PropertyServiceInterface {

    /**
     * 
     * @var PropertyMapperInterface
     */
    private $propertyMapper;

    /**
     */
    function __construct(PropertyMapperInterface $propertyMapper) {
        $this->propertyMapper = $propertyMapper;
    }

    /* (non-PHPdoc)
     * @see \Property\Service\PropertyServiceInterface::findAll()
     */

    public function findAll($array = false) {
        $properties = $this->propertyMapper->findAll();
        return !$array ? $properties : $properties->toArray();
    }

    /* (non-PHPdoc)
     * @see \Property\Service\PropertyServiceInterface::findById()
     */

    public function findById($id, $array = false) {
        $property = $this->propertyMapper->findById($id);
        return !$array ? $property : $this->propertyMapper->entityToArray($property);
    }

    /* (non-PHPdoc)
     * @see \Property\Service\PropertyServiceInterface::findByName()
     */

    public function findByName($name, $array = false) {
        $property = $this->propertyMapper->findByName($name);
        return !$array ? $property : $this->propertyMapper->entityToArray($property);
    }

    /* (non-PHPdoc)
     * @see \Property\Service\PropertyServiceInterface::insert()
     * @todo incase of invalid $property entry (maybe if the property to insert already exist), trycatch the exception.
     * return null if an exception is thrown.
     */

    public function insert(PropertyInterface $property) {
        $this->propertyMapper->insert($property);
        return $property;
    }

    /* (non-PHPdoc)
     * @see \Property\Service\PropertyServiceInterface::update()
     * @todo incase of invalid $property entry (maybe if the property to insert already exist), trycatch the exception.
     * return null if an exception is thrown.
     */

    public function update(PropertyInterface $property, $where = null) {
        $this->propertyMapper->update($property, $where);
        return $property;
    }

    /* (non-PHPdoc)
     * @see \Property\Service\PropertyServiceInterface::delete()
     */

    public function delete(PropertyInterface $property) {
        $where = ['id = ?' => $property->getId()];
        $this->propertyMapper->delete($where);
        return $property;
    }

    public function getPropertyMapper() {
        return $this->propertyMapper;
    }

    public function setPropertyMapper(PropertyMapperInterface $mapper) {
        $this->propertyMapper = $mapper;
        return $this;
    }

}
