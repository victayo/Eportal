<?php

namespace EportalUser\Service;

use EportalUser\Mapper\RelUserPropertyValueMapper;
use EportalUser\Model\EportalUser;
use EportalUser\Model\RelUserPropertyValue;
use Property\Model\PropertyValueInterface;

/**
 *
 * @author imaleo
 */
class RelUserPropertyValueService {
    /**
     *
     * @var RelUserPropertyValueMapper
     */
    protected $mapper;
    
    public function __construct(RelUserPropertyValueMapper $mapper) {
        $this->mapper = $mapper;
    }
    
    public function getEntity($parent, $userPropertyValue){
        $entity = $this->mapper->getEntityPrototype();
        $entity->setParent($parent)
                ->setUserPropertyValue($userPropertyValue);
        return $entity;
//        return new RelUserPropertyValue($parent, $userPropertyValue);
    }
    
    public function insert(RelUserPropertyValue $entity){
        if($this->hasRelUserPropertyValue($entity)){
            return null;
        }
        return $this->mapper->insert($entity);
    }
    
    public function update(RelUserPropertyValue $oldEntity, RelUserPropertyValue $newEntity){
        if(!$this->hasRelUserPropertyValue($oldEntity) || $this->hasRelUserPropertyValue($newEntity)){
            return false;
        }
        $this->mapper->delete(array(
            'parent = ?' => $oldEntity->getParent(),
            'user_property_value = ?' => $oldEntity->getUserPropertyValue()
        ));
        $this->insert($newEntity);
        return true;
    }
    
    public function delete(RelUserPropertyValue $entity){
        if(!$this->hasRelUserPropertyValue($entity)){
            return null;
        }
        return $this->mapper->delete(array(
            'parent = ?' => $entity->getParent(),
            'user_property_value = ?' => $entity->getUserPropertyValue()
        ));
    }
    
    public function hasRelUserPropertyValue($relUserPropertyValue){
        return $this->mapper->hasRelUserPropertyValue($relUserPropertyValue);
    }
    
    public function getChildren(EportalUser $user, PropertyValueInterface $session, PropertyValueInterface $term, PropertyValueInterface $propertyValue, $deep = false){
        if($deep){
            return $this->mapper->getAllSubCategories($user->getId(), $session->getId(), $term->getId(), $propertyValue->getId());
        }
        return $this->mapper->getSubcategories($user->getId(), $session->getId(), $term->getId(), $propertyValue->getId());
    }
    
    public function getPropertyValues(EportalUser $user, PropertyValueInterface $session, PropertyValueInterface $term, PropertyValueInterface $propertyValue, $property){
        $results = $this->getChildren($user, $session, $term, $propertyValue, TRUE);
        $return = [];
        foreach ($results as $result){
            $pv = $result['property_value'];
            if($pv->getProperty()->getName() == $property){
                $return[] = $pv;
            }else{
                $return = $this->extract($result['child'], $property);
            }
        }
        return $return;
    }
    
    private function extract($children, $property){
        if(!count($children)){
            return [];
        }
        foreach($children as $child){
            $pv = $child['property_value'];
            if($pv->getProperty()->getName() == $property){
                $return[] = $pv;
            }else{
                $return = $this->extract($child['child'], $property);
            }
        }
        return $return;
    }
}
