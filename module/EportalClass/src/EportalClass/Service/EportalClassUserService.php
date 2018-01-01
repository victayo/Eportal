<?php


namespace EportalClass\Service;

use EportalClass\Mapper\EportalClassUserMapperInterface;

/**
 * @author OKALA
 */
class EportalClassUserService implements EportalClassUserServiceInterface{
    /**
     *
     * @var EportalClassUserMapperInterface
     */
    protected $eportalClassUserMapper;
    
    public function __construct(EportalClassUserMapperInterface $eportalClassUserMapper) {
        $this->eportalClassUserMapper = $eportalClassUserMapper;
    }

    public function addUser($user, $session, $term, $school, $class, $addSubjects = true) {
        return $this->eportalClassUserMapper->addUser($user, $session, $term, $school, $class, $addSubjects);
    }

    public function getUsers($session, $term, $school, $class, $role = null) {
        return $this->eportalClassUserMapper->getUsers($session, $term, $school, $class, $role);
    }

    public function getUnregisteredUsers($session, $term, $school, $class, $role) {
        return $this->eportalClassUserMapper->getUnregisteredUsers($session, $term, $school, $class, $role);
    }

    public function removeUser($user, $session, $term, $school, $class) {
        return $this->eportalClassUserMapper->removeUser($user, $session, $term, $school, $class);
    }

}
