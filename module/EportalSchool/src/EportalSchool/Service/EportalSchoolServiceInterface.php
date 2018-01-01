<?php

namespace EportalSchool\Service;

use Property\Model\PropertyValueInterface;

/**
 *
 * @author imaleo
 */
interface EportalSchoolServiceInterface {
    
public function getSchoolProperty();

public function getSchool($school_id = null);

public function saveSchool(PropertyValueInterface $school);

public function deleteSchool($school);

public function getClasses($school);

public function addClass($school, $class);

public function removeClass($school, $class);

public function hasClass($school, $class);

public function getUnmappedClasses($school);
}
