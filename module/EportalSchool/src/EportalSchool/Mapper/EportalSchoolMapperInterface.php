<?php

namespace EportalSchool\Mapper;

/**
 *
 * @author imaleo
 */
interface EportalSchoolMapperInterface {

    public function getClasses($school);
    
    public function addClass($school, $class);

    public function hasClass($school, $class);
    
    public function removeClass($school, $class);
    
    public function removeSchool($school);
    
    public function getUnmappedClasses($school);
    
    public function getRelPropertyValue($school);
}
