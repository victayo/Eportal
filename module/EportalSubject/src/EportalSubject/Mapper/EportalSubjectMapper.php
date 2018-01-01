<?php

namespace EportalSubject\Mapper;

use Property\Mapper\AbstractPropertyDbMapper;
use Zend\Db\Sql\Select;

/**
 * @author OKALA
 */
class EportalSubjectMapper extends AbstractPropertyDbMapper implements EportalSubjectMapperInterface {

    public function getRelPropertyValue($school, $class, $department, $subject) {
        $where = [
            'school.property_value' => $school,
            'class.property_value' => $class,
            'subject.property_value' => $subject
        ];
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT);
        if ($department) {
            $select->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                    ->join(['subject' => $this->tableName], 'subject.parent = department.id', ['id', 'parent', 'property_value'], Select::JOIN_LEFT);
            $where['department.property_value'] = $department;
        } else {
            $select->join(['subject' => $this->tableName], 'subject.parent = class.id', ['id', 'parent', 'property_value'], Select::JOIN_LEFT);
        }
        $select->where($where)
                ->columns([]);
        return $this->select($select)->current();
    }

    public function getSchoolSubject($school) {
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
                    'property.name' => 'subject'
                ])
                ->columns([])
                ->quantifier(Select::QUANTIFIER_DISTINCT);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    public function getClassSubject($school, $class) {
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
                    'property.name' => 'subject'
                ])
                ->columns([])
                ->quantifier(Select::QUANTIFIER_DISTINCT);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    public function getDepartmentSubject($school, $class, $department) {
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

    public function getSchool($subject) {
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['subject' => $this->tableName], 'subject.parent = department.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = subject.property_value')
                ->join($propTable, $propTable . '.id = ' . $pvTable . '.property', [])
                ->where([
                    'subject.property_value' => $subject,
                    'property.name' => 'school'
                ])
                ->columns([])
                ->quantifier(Select::QUANTIFIER_DISTINCT);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    public function getClass($school, $subject) {
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
                    'subject.property_value' => $subject,
                    'property.name' => 'class'
                ])
                ->columns([]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    public function getDepartment($school, $subject) {
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
                    'subject.property_value' => $subject,
                    'property.name' => 'department'
                ])
                ->columns([]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    public function getSubject($school, $class, $department, $subject) {
        return $this->getRelPropertyValue($school, $class, $department, $subject);
    }

}
