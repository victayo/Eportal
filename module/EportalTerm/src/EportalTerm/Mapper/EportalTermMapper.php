<?php

namespace EportalTerm\Mapper;

use Property\Mapper\AbstractPropertyDbMapper;
use Zend\Db\Sql\Select;

/**
 * @author OKALA
 */
class EportalTermMapper extends AbstractPropertyDbMapper implements EportalTermMapperInterface {

    public function getRelPropertyValue($school, $class, $department, $term) {
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['term' => $this->tableName], 'term.parent = department.id', ['id', 'parent', 'property_value'], Select::JOIN_LEFT)
                ->where([
                    'school.property_value' => $school,
                    'class.property_value' => $class,
                    'department.property_value' => $department,
                    'term.property_value' => $term
                ])
                ->columns([]);
        return $this->select($select)->current();
    }

    public function getSchoolTerm($school) {
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['term' => $this->tableName], 'term.parent = department.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = term.property_value')
                ->join($propTable, $propTable . '.id = ' . $pvTable . '.property', [])
                ->where([
                    'school.property_value' => $school,
                    'property.name' => 'term'
                ])
                ->columns([])
                ->quantifier(Select::QUANTIFIER_DISTINCT);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    public function getClassTerm($school, $class){
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['term' => $this->tableName], 'term.parent = department.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = term.property_value')
                ->join($propTable, $propTable . '.id = ' . $pvTable . '.property', [])
                ->where([
                    'school.property_value' => $school,
                    'class.property_value' => $class,
                    'property.name' => 'term'
                ])
                ->columns([])
                ->quantifier(Select::QUANTIFIER_DISTINCT);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }
    
    public function getDepartmentTerm($school, $class, $department){
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['term' => $this->tableName], 'term.parent = department.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = term.property_value')
                ->join($propTable, $propTable . '.id = ' . $pvTable . '.property', [])
                ->where([
                    'school.property_value' => $school,
                    'class.property_value' => $class,
                    'department.property_value' => $department,
                    'property.name' => 'term'
                ])
                ->columns([]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }
    
    public function getSchool($term){
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['term' => $this->tableName], 'term.parent = department.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = term.property_value')
                ->join($propTable, $propTable . '.id = ' . $pvTable . '.property', [])
                ->where([
                    'term.property_value' => $term,
                    'property.name' => 'school'
                ])
                ->columns([])
                ->quantifier(Select::QUANTIFIER_DISTINCT);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }
    
    public function getClass($school, $term){
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['term' => $this->tableName], 'term.parent = department.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = term.property_value')
                ->join($propTable, $propTable . '.id = ' . $pvTable . '.property', [])
                ->where([
                    'school.property_value' => $school,
                    'term.property_value' => $term,
                    'property.name' => 'class'
                ])
                ->columns([]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }
    
    public function getDepartment($school, $term){
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $select = $this->getSelect(['school' => $this->tableName])
                ->join(['class' => $this->tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $this->tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['term' => $this->tableName], 'term.parent = department.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = term.property_value')
                ->join($propTable, $propTable . '.id = ' . $pvTable . '.property', [])
                ->where([
                    'school.property_value' => $school,
                    'term.property_value' => $term,
                    'property.name' => 'department'
                ])
                ->columns([]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    public function getTerm($school, $class, $department, $term) {
        return $this->getRelPropertyValue($school, $class, $department, $term);
    }

}
