<?php

namespace EportalSchool\Mapper;

use Property\Mapper\AbstractPropertyDbMapper;
use Zend\Db\Sql\Select;

/**
 *
 * @author imaleo
 */
class EportalSchoolMapper extends AbstractPropertyDbMapper implements EportalSchoolMapperInterface{
    
    public function getClasses($school) {
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = class.property_value')
                ->where(['school.property_value' => $school])
                ->columns([]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    public function addClass($school, $class){
        $schoolRpv = $this->getRelPropertyValue($school);
        if(!$schoolRpv){//$school has not been added to the rel_property_value table. Insert.
            $schoolRpv = $this->getEntityPrototype()
                    ->setPropertyValue($school);
            $this->save($schoolRpv);
        }
        $parentId = $schoolRpv->getId();
        $insertEntity = $this->getEntityPrototype()
                ->setId(null)
                ->setParent($parentId)
                ->setPropertyValue($class);
        return $this->save($insertEntity);
    }

    public function hasClass($school, $class) {
        /**
         * select * from rel_property_value as school
         * left join rel_property_value as class on class.parent = school.id
         * where school.property_value = $schoolPropertyValue
         *  and class.property_value = $classPropertyValue
         */
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->where([
            'school.property_value' => $school,
            'class.property_value' => $class
        ]);
        return boolval($this->select($select)->count());
    }

    public function removeClass($school, $class) {
        $parent = $this->getRelationship($school, $class);
        $id = $parent->getId();
        if ($id) {
            $this->delete(['id' => $id]);
            return true;
        }
        return false;
    }

    public function removeSchool($school){
        $classes = $this->getClasses($school);
        foreach ($classes as $class) {
            $this->removeClass($school, $class->getId());
        }
        $schoolRpv = $this->getRelPropertyValue($school);
        $this->delete(['id' => $schoolRpv->getId()]);
    }
    
    public function getRelationship($school, $class) {
        /**
         * select child.* from rel_property_value as parent
         * join rel_property_value as child on child.parent = parent.id
         * where parent.property_value = $parentPropertyValue
         *  and child.property_value = $childPropertyValue
         */
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id')
                ->where([
                    'school.property_value' => $school,
                    'class.property_value' => $class
                ])
                ->columns([]);
        return $this->select($select)->current();
    }
    
    public function getUnmappedClasses($school){
        /**
         * Select property_value.* from property_value
         * left join (select property_value.id as mc_id from rel_property_value as school
         * left join rel_property_value as class on class.parent = school.id
         * join property_value on property_value.id = class.property_value
         * where school.property_value = $school) as mappedClasses
         * on mappedClasses.mc_id = property_value.id
         * join property on property_value.property = property.id
         * where property.name = 'class'
         * and mc_id is null
         */
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $subselect = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['pv' => $pvTable], 'pv.id = class.property_value', ['id'])
                ->where(['school.property_value' => $school])
                ->columns([]);
        $select = $this->getSelect($pvTable)
                ->join(['mappedClasses' => $subselect], 'mappedClasses.id = property_value.id',[], Select::JOIN_LEFT)
                ->join(['prop' => $propTable], 'property_value.property = prop.id', [])
                ->where(['prop.name' => 'class', 'mappedClasses.id' => null]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }
    
    public function getRelPropertyValue($school) {
        $select = $this->getSelect()
                ->where(['property_value' => $school, 'parent' => null]);
        return $this->select($select)->current();
    }
}
