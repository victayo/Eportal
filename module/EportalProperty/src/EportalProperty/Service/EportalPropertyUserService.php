<?php

namespace EportalProperty\Service;

use EportalProperty\Mapper\EportalPropertyUserMapper;

/**
 * @author OKALA
 */
class EportalPropertyUserService {
    
    /**
     *
     * @var EportalPropertyUserMapper
     */
    protected $mapper;
    
    public function __construct(EportalPropertyUserMapper $mapper) {
        $this->mapper = $mapper;
    }

    public function getSchool($user, $session, $term){
        return $this->mapper->getSchool($user, $session, $term);
    }
    
    public function getClass($user, $session, $term){
        return $this->mapper->getClass($user, $session, $term);
    }
    
    public function getSubject($user, $session, $term){
        return $this->mapper->getsubject($user, $session, $term);
    }
    
    public function getDepartment($user, $session, $term){
        return $this->mapper->getDepartment($user, $session, $term);
    }
    
    public function getEportalPropertyUserMapper() {
        return $this->mapper;
    }

    public function setEportalPropertyUserMapper(EportalPropertyUserMapper $mapper) {
        $this->mapper = $mapper;
        return $this;
    }


}
