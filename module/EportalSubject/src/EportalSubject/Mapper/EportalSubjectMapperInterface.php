<?php

namespace EportalSubject\Mapper;

/**
 *
 * @author OKALA
 */
interface EportalSubjectMapperInterface {
    
    public function getSubject($school, $class, $department, $subject);
    
    public function getSchool($subject);
    
    public function getClass($school, $subject);
    
    public function getDepartment($school, $subject);

//    public function removeSubject($school, $class, $department, $subject);
        
    public function getRelPropertyValue($school, $class, $department, $subject);
    
}
