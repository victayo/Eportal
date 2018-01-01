<?php

namespace EportalTerm\Mapper;

/**
 *
 * @author OKALA
 */
interface EportalTermMapperInterface {
    
    public function getTerm($school, $class, $department, $term);
    
    public function getSchool($term);
    
    public function getClass($school, $term);
    
    public function getDepartment($school, $term);

//    public function removeTerm($school, $class, $department, $term);
        
    public function getRelPropertyValue($school, $class, $department, $term);
    
}
