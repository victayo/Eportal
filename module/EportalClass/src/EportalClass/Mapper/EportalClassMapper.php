<?php

namespace EportalClass\Mapper;

use Property\Mapper\AbstractPropertyDbMapper;
use Zend\Db\Sql\Select;

/**
 * Description of EportalClassMapper
 *
 * @author OKALA
 */
class EportalClassMapper extends AbstractPropertyDbMapper implements EportalClassMapperInterface {

    public function addDepartment($school, $class, $department) {
        $schoolClass = $this->getRelPropertyValue($school, $class);
        $entity = $this->getEntityPrototype(true)
                ->setParent($schoolClass->getId())
                ->setPropertyValue($department);
        return $this->save($entity);
    }

    public function addSubject($school, $class, $subject) {
        $schoolClass = $this->getRelPropertyValue($school, $class);
        $entity = $this->getEntityPrototype(true)
                ->setParent($schoolClass->getId())
                ->setPropertyValue($subject);
        return $this->save($entity);
    }

    public function getSchools($class) {
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = school.property_value')
                ->join($propTable, $propTable . '.id = ' . $pvTable . '.property', [])
                ->where(['class.property_value' => $class, 'property.name' => 'school'])
                ->columns([]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    public function getDepartments($school, $class) {
        /**
         * Select property_value.* from rel_property_value as parent
         * left join rel_property_value as child on child.parent = parent.id
         * join property_value on property_value.id = child.property_value
         * where parent.property_value = $propertyValue
         */
        return $this->getClassChildren($school, $class, 'department');
    }

    public function getSubjects($school, $class) {
        return $this->getClassChildren($school, $class, 'subject');
    }

    public function getUnaddedDepartment($school, $class) {
        return $this->getUnaddedChild($school, $class, 'department');
    }

    public function getUnaddedSubjects($school, $class) {
        return $this->getUnaddedChild($school, $class, 'subject');
    }

    public function hasDepartment($school, $class, $department) {
        return $this->hasProperty($school, $class, $department);
    }

    public function hasSubject($school, $class, $subject) {
        return $this->hasProperty($school, $class, $subject);
    }

    public function removeDepartment($school, $class, $department) {
//        if (!$department) {//remove all departments
//            $departments = $this->getDepartments($school, $class);
//            foreach ($departments as $dept) {
//                $this->removeDepartment($school, $class, $dept);
//            }
//        } else {
//            return $this->removeProperty($school, $class, $department);
//        }
        return $this->removeProperty($school, $class, $department);
    }

    public function removeSubject($school, $class, $subject) {
        return $this->removeProperty($school, $class, $subject);
    }

    public function removeClass($school, $class){
        $subjects = $this->getSubjects($school, $class);
        $departments = $this->getDepartments($school, $class);
        foreach($subjects as $subject){
            $this->removeSubject($school, $class, $subject->getId());
        }
        foreach($departments as $department){
            $this->removeDepartment($school, $class, $department->getId());
        }
        $classRpv = $this->getRelPropertyValue($school, $class);
        $this->delete(['id' => $classRpv->getId()]);
    }
    
    public function getRelPropertyValue($school, $class) {
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id')
                ->where([
                    'school.property_value' => $school,
                    'class.property_value' => $class
                ])
                ->columns([]);
        return $this->select($select)->current();
    }

    protected function getClassChildren($school, $class, $property) {
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['child' => $this->tableName], 'child.parent = class.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = child.property_value')
                ->join($propTable, $propTable . '.id = ' . $pvTable . '.property', [])
                ->where(['school.property_value' => $school, 'class.property_value' => $class, 'property.name' => $property])
                ->columns([]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    protected function getUnaddedChild($school, $class, $childProperty) {
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $subselect = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['child' => $this->tableName], 'child.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['pv' => $pvTable], 'pv.id = child.property_value', ['id'])
                ->where(['school.property_value' => $school, 'class.property_value' => $class])
                ->columns([]);
        $select = $this->getSelect($pvTable)
                ->join(['mappedChildren' => $subselect], 'mappedChildren.id = property_value.id', [], Select::JOIN_LEFT)
                ->join(['prop' => $propTable], 'property_value.property = prop.id', [])
                ->where(['prop.name' => $childProperty, 'mappedChildren.id' => null]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    protected function hasProperty($school, $class, $property) {
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['child' => $this->tableName], 'child.parent = class.id', [], Select::JOIN_LEFT)
                ->where([
            'school.property_value' => $school,
            'class.property_value' => $class,
            'child.property_value' => $property
        ]);
        return boolval($this->select($select)->count());
    }

    protected function removeProperty($school, $class, $property) {
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['child' => $this->tableName], 'child.parent = class.id', ['id'], Select::JOIN_LEFT)
                ->where(['school.property_value' => $school, 'class.property_value' => $class, 'child.property_value' => $property])
                ->columns([]);
        $rpv = $this->select($select)->current();
        return $this->delete(['id' => $rpv->getId()]);
    }

}
