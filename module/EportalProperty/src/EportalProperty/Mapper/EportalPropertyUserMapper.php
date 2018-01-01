<?php

namespace EportalProperty\Mapper;

/**
 * @author OKALA
 */
class EportalPropertyUserMapper extends AbstractEportalPropertyUserMapper{
    
    public function getSchool($user, $session, $term){
        return $this->getUserProperty($user, $session, $term, self::EPORTAL_SCHOOL);
    }
    
    public function getClass($user, $session, $term) {
        return $this->getUserProperty($user, $session, $term, self::EPORTAL_CLASS);
    }

    public function getDepartment($user, $session, $term) {
        return $this->getUserProperty($user, $session, $term, self::EPORTAL_DEPARTMENT);
    }
    
    public function getsubject($user, $session, $term) {
        return $this->getUserProperty($user, $session, $term, self::EPORTAL_SUBJECT);
    }
}
