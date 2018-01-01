<?php

namespace EportalSchool\Mapper;

use EportalProperty\Mapper\AbstractEportalPropertyUserMapper;

/**
 * @author OKALA
 */
class EportalSchoolUserMapper extends AbstractEportalPropertyUserMapper implements EportalSchoolUserMapperInterface {

    /**
     *
     * @var EportalSchoolMapperInterface
     */
    protected $eportalSchoolMapper;

    public function __construct(EportalSchoolMapperInterface $eportalSchoolMapper) {
        $this->eportalSchoolMapper = $eportalSchoolMapper;
    }

    public function addUser($user, $session, $term, $school) {
        $rpv = $this->eportalSchoolMapper->getRelPropertyValue($school);
        if($this->addUserHelper($user, $session, $term, $rpv)){
            return true;
        }
        return false;
    }

    public function getUsers($session, $term, $school, $role = null) {
        $rpv = $this->eportalSchoolMapper->getRelPropertyValue($school);
        return $this->getUsersHelper($session, $term, $rpv, $role);
    }

    public function removeUser($user, $session, $term, $school) {
        $rpv = $this->eportalSchoolMapper->getRelPropertyValue($school);
        return $this->removeUserHelper($user, $session, $term, $rpv);
    }

}
