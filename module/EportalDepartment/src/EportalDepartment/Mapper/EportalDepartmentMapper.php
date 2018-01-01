<?php

namespace EportalDepartment\Mapper;

use Property\Mapper\AbstractPropertyDbMapper;
use Zend\Db\Sql\Select;

/**
 * @author OKALA
 */
class EportalDepartmentMapper extends AbstractPropertyDbMapper implements EportalDepartmentMapperInterface {

    public function addSubject($school, $class, $department, $subject) {
        $departmentRpv = $this->getRelPropertyValue($school, $class, $department);
        $entity = $this->getEntityPrototype()
                ->setParent($departmentRpv->getId())
                ->setPropertyValue($subject);
        return $this->save($entity);
    }

    public function getRelPropertyValue($school, $class, $department) {
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', ['id', 'parent', 'property_value'], Select::JOIN_LEFT)
                ->where([
                    'school.property_value' => $school,
                    'class.property_value' => $class,
                    'department.property_value' => $department
                ])
                ->columns([]);
        return $this->select($select)->current();
    }

    public function getSubject($school, $class, $department) {
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['subject' => $this->tableName], 'subject.parent = department.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = subject.property_value')
                ->join($propTable, $propTable . '.id = ' . $pvTable . '.property', [])
                ->where([
                    'school.property_value' => $school,
                    'class.property_value' => $class,
                    'department.property_value' => $department,
                    'property.name' => 'subject'
                ])
                ->columns([]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    public function getSchool($department){
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['subject' => $this->tableName], 'subject.parent = department.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = subject.property_value')
                ->join($propTable, $propTable . '.id = ' . $pvTable . '.property', [])
                ->where([
                    'department.property_value' => $department,
                    'property.name' => 'school'
                ])
                ->columns([]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }
    
    public function getClass($school, $department){
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['subject' => $this->tableName], 'subject.parent = department.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = subject.property_value')
                ->join($propTable, $propTable . '.id = ' . $pvTable . '.property', [])
                ->where([
                    'school.property_value' => $school,
                    'department.property_value' => $department,
                    'property.name' => 'class'
                ])
                ->columns([]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }
    
    public function getUnaddedSubject($school, $class, $department) {
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $subselect = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['subject' => $this->tableName], 'subject.parent = department.id', [], Select::JOIN_LEFT)
                ->join(['pv' => $pvTable], 'pv.id = subject.property_value', ['id'])
                ->where(['school.property_value' => $school, 'class.property_value' => $class, 'department.property_value' => $department])
                ->columns([]);
        $select = $this->getSelect($pvTable)
                ->join(['mappedChildren' => $subselect], 'mappedChildren.id = property_value.id', [], Select::JOIN_LEFT)
                ->join(['prop' => $propTable], 'property_value.property = prop.id', [])
                ->where(['prop.name' => 'subject', 'mappedChildren.id' => null]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    public function hasSubject($school, $class, $department, $subject) {
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['subject' => $this->tableName], 'subject.parent = department.id', ['id', 'parent', 'property_value'], Select::JOIN_LEFT)
                ->where([
                    'school.property_value' => $school,
                    'class.property_value' => $class,
                    'department.property_value' => $department,
                    'subject.property_value' => $subject
                ])
                ->columns([]);
        return boolval($this->select($select)->count());
    }

    public function removeDepartment($school, $class, $department) {
        $subjects = $this->getSubject($school, $class, $department);
        foreach ($subjects as $subject) {
            $this->removeSubject($school, $class, $department, $subject->getId());
        }
        $departmentRpv = $this->getRelPropertyValue($school, $class, $department);
        return $this->delete(['id' => $departmentRpv->getId()]);
    }

    public function removeSubject($school, $class, $department, $subject) {
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['subject' => $this->tableName], 'subject.parent = department.id', ['id'], Select::JOIN_LEFT)
                ->where([
                    'school.property_value' => $school,
                    'class.property_value' => $class,
                    'department.property_value' => $department,
                    'subject.property_value' => $subject
                ])
                ->columns([]);
        $rpv = $this->select($select)->current();
        return $this->delete(['id' => $rpv->getId()]);
    }
}
