<?php

namespace Property\Service;

use Property\Mapper\PropertyValueMapperInterface;
use Property\Model\Property;
use Property\Model\PropertyInterface;
use Property\Model\PropertyValue;
use Property\Model\PropertyValueInterface;

/**
 * Description of PropertyValueService
 *
 * @author imaleo
 */
class PropertyValueService implements PropertyValueServiceInterface {

    /**
     *
     * @var PropertyValueMapperInterface
     */
    private $mapper;

    public function __construct(PropertyValueMapperInterface $mapper) {
        $this->mapper = $mapper;
    }

    public function getEntity($id = null, $value = null, PropertyInterface $property = null) {
        return new PropertyValue($id, $value, $property);
    }

    public function delete(PropertyValueInterface $propertyValue) {
        return $this->mapper->delete(['id = ?' => $propertyValue->getId()]);
    }

    public function findAll($array = false) {
        $pvs = $this->mapper->findAll();
        return !$array ? $pvs : $pvs->toArray();
    }

    public function save($propertyValue) {
        return $this->mapper->save($propertyValue);
    }

    public function findById($id, $array = false) {
        $pv = $this->mapper->findById($id);
        return !$array ? $pv : $this->mapper->entityToArray($pv);
    }

    public function findByProperty(Property $property, $array = false) {
        $pvs = $this->mapper->findByProperty($property->getId());
        return !$array ? $pvs : $pvs->toArray();
    }

    public function insert(PropertyValueInterface $propertyValue) {
        $this->mapper->insert($propertyValue);
        return $propertyValue;
    }

    public function update(PropertyValueInterface $propertyValue, $where = null) {
        $this->mapper->update($propertyValue, $where);
        return $propertyValue;
    }

    public function getPropertyCount(Property $property) {
        return $this->findByProperty($property)->count();
    }

    /**
     * 
     * @param PropertyValueMapperInterface $mapper
     * @return PropertyValueService
     */
    public function setPropertyValueMapper(PropertyValueMapperInterface $mapper) {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * 
     * @return PropertyValueMapperInterface
     */
    public function getPropertyValueMapper() {
        return $this->mapper;
    }

    public function getId(PropertyInterface $property, $value) {
        return $this->mapper->getId($property->getId(), strtolower($value));
    }

    public function toId($propertyValue) {
        if (is_numeric($propertyValue)) {
            return $propertyValue;
        }
        if ($propertyValue instanceof PropertyValueInterface) {
            return $propertyValue->getId();
        }
        throw new \InvalidArgumentException('Expected an integer (string) or object of type PropertyValueInterface');
    }

    public function toPropertyValue($propertyValue) {
        if (is_numeric($propertyValue)) {
            return $this->findById($propertyValue);
        }
        if ($propertyValue instanceof PropertyValueInterface) {
            return $propertyValue;
        }
        throw new \InvalidArgumentException('Expected an integer (string) or object of type PropertyValueInterface');
    }

}
