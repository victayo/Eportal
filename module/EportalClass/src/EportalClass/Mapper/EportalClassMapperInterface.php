<?php

namespace EportalClass\Mapper;

/**
 *
 * @author OKALA
 */
interface EportalClassMapperInterface {

    public function getSchools($class);

    public function getDepartments($school, $class);

    public function getSubjects($school, $class);

    public function addSubject($school, $class, $subject);

    public function addDepartment($school, $class, $department);

    public function removeSubject($school, $class, $subject);

    public function removeDepartment($school, $class, $department);
    
    public function removeClass($school, $class);

    public function hasSubject($school, $class, $subject);

    public function hasDepartment($school, $class, $department);

    public function getUnaddedSubjects($school, $class);

    public function getUnaddedDepartment($school, $class);
    
    public function getRelPropertyValue($school, $class);
}
