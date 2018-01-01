<?php
namespace Property\Service;

use Property\Model\Property;
use Property\Model\PropertyInterface;
use Property\Model\PropertyValueInterface;

/**
 *
 * @author imaleo
 *        
 */
interface PropertyValueServiceInterface
{
    public function findAll($array = false);
    public function findById($id, $array = false);
    public function findByProperty(Property $property, $array = false);
    public function getId(PropertyInterface $property, $value);
    /**
     * 
     * @param int $id
     * @param string $value
     * @param PropertyInterface $property
     * @return PropertyValueInterface 
     */
    public function getEntity($id = null, $value = null, PropertyInterface $property = null);
    public function save($propertyValue);
    public function delete(PropertyValueInterface $propertyValue);
    
    public function toId($propertyValue);
    
    public function toPropertyValue($propertyValue);
    
    public function getPropertyCount(Property $property);
}
