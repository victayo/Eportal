<?php

namespace Property\Mapper;

use Property\Mapper\Hydrator\PropertyValueHydrator;
use Property\Model\PropertyValueInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZfcBase\Mapper\AbstractDbMapper;
/**
 *
 * @author imaleo
 *        
 */
abstract class AbstractPropertyDbMapper extends AbstractDbMapper {
    const PROPERTY_TABLE = 'property';
    const PROPERTY_VALUE_TABLE = 'property_value';
    const REL_PROPERTY_VALUE_TABLE = 'rel_property_value';

    /**
     *
     * @var PropertyValueHydrator
     */
    protected $propertyValueHydrator;

    /**
     *
     * @var PropertyValueInterface
     */
    protected $propertyValueEntity;
    
    public function save($entity){
        $id = $entity->getId();
        if(!$id){
            $result = parent::insert($entity);
            $entity->setId($result->getGeneratedValue());
        }else{
            parent::update($entity, ['id' => $id]);
        }
        return $entity;
    }
    
    public function delete($where = null, $tableName = null) {
        return parent::delete($where, $tableName);
    }

    public function setTableName($tableName) {
        $this->tableName = $tableName;
        return $this;
    }

    public function getTableName() {
        return $this->tableName;
    }
    
    public function getPropertyValueEntity() {
        return $this->propertyValueEntity;
    }

    public function getPropertyValueHydrator() {
        return $this->propertyValueHydrator;
    }
    
     public function setPropertyValueEntity(PropertyValueInterface $propertyValueEntity) {
        $this->propertyValueEntity = $propertyValueEntity;
        return $this;
    }

    public function setPropertyValueHydrator(PropertyValueHydrator $pvHydrator) {
        $this->propertyValueHydrator = $pvHydrator;
        return $this;
    }
    
    public function getEntityPrototype($new = true) {
        $entityPrototype = parent::getEntityPrototype();
        if($new){
            $class = get_class($entityPrototype);
            return new $class;
        }
        return $entityPrototype;
    }
    
    public function entityToArray($entity, HydratorInterface $hydrator = null) {
        return parent::entityToArray($entity, $hydrator);
    }
}
