<?php

namespace EportalSchool\Service;

use EportalSchool\Mapper\EportalSchoolUserMapperInterface;

/**
 * @author OKALA
 */
class EportalSchoolUserService implements EportalSchoolUserServiceInterface{
    
    /**
     *
     * @var EportalSchoolUserMapperInterface
     */
    protected $eportalSchoolUserMapper;
    
    public function __construct(EportalSchoolUserMapperInterface $eportalSchoolUserMapper) {
        $this->eportalSchoolUserMapper = $eportalSchoolUserMapper;
    }

    public function addUser($user, $session, $term, $school) {
        return $this->eportalSchoolUserMapper->addUser($user, $session, $term, $school);
    }

    public function getUsers($session, $term, $school, $role = null) {
        return $this->eportalSchoolUserMapper->getUsers($session, $term, $school, $role);
    }

    public function removeUser($user, $session, $term, $school) {
        return $this->eportalSchoolUserMapper->removeUser($user, $session, $term, $school);
    }
}
