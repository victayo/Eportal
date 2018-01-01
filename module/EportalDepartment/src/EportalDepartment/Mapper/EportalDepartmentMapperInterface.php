<?php

namespace EportalDepartment\Mapper;

/**
 *
 * @author OKALA
 */
interface EportalDepartmentMapperInterface {
    
    public function addSubject($school, $class, $department, $subject);
    
    public function getSubject($school, $class, $department);
    
    public function getSchool($department);
    
    public function getClass($school, $department);
    
    public function hasSubject($school, $class, $department, $subject);
    
    public function removeSubject($school, $class, $department, $subject);
    
    public function removeDepartment($school, $class, $department);
    
    public function getUnaddedSubject($school, $class, $department);

    public function getRelPropertyValue($school, $class, $department);
    
}
