<?php

namespace EportalUser\Mapper;

use EportalUser\Model\RelUserPropertyValue;
use EportalUser\Model\UserRelPropertyValue;

/**
 *
 * @author imaleo
 */
class RelUserPropertyValueMapper extends EportalAbstractDbMapper {

    protected $tableName = 'rel_user_property_value';

    public function getAllSubCategories($user, $session, $term, $propertyValue) {
        $results = $this->getSubcategories($user, $session, $term, $propertyValue);
        $propertyValues = [];
        foreach ($results as $result){
            $propertyValues[] = array(
                'property_value' => $result,
                'child' => $this->getAllSubCategories($user, $session, $term, $result->getId())
            );
        }
        return $propertyValues;
    }

    protected function getUserPropertyValueId($user, $session, $term, $propertyValue) {
        $where = array(
            'user = ?' => $user,
            'session = ?' => $session,
            'term = ?' => $term,
            'property_value = ?' => $propertyValue
        );
        $select = $this->getSelect($this->ustTable)
                ->join($this->upvTable, $this->upvTable . '.user_session_term = ' . $this->ustTable.'.id')
                ->where($where)
                ->columns(array());
        $result = $this->select($select, new UserRelPropertyValue());
        if ($result->count() > 0) {
            return $result->current()->getId();
        }
        return null;
    }

    public function getSubcategories($user, $session, $term, $propertyValue){
        $parent = $this->getUserPropertyValueId($user, $session, $term, $propertyValue);
        $select = $this->getSelect()
                ->join($this->upvTable, $this->upvTable.'.id = '.$this->tableName.'.user_property_value', array())
                ->join($this->propertyValueTable, $this->upvTable.'.property_value = '.$this->propertyValueTable.'.id')
                ->where(array(
                    $this->tableName.'.parent = ?' => $parent
                ))
                ->order($this->propertyValueTable.'.property ASC', $this->propertyValueTable.'.value ASC')
                ->columns(array()); 
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }
    
    public function hasRelUserPropertyValue(RelUserPropertyValue $relUserPropertyValue){
        $select = $this->getSelect()
                ->where(array(
                    'parent=?' => $relUserPropertyValue->getParent(),
                    'user_property_value=?' => $relUserPropertyValue->getUserPropertyValue()
                ));
        $result = $this->select($select);
        return boolval($result->count());
    }
}
