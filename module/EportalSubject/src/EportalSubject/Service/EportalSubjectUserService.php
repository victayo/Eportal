<?php

namespace EportalSubject\Service;

use EportalSubject\Mapper\EportalSubjectUserMapperInterface;

/**
 * @author OKALA
 */
class EportalSubjectUserService implements EportalSubjectUserServiceInterface {

    /**
     *
     * @var EportalSubjectUserMapperInterface
     */
    protected $eportalSubjectUserMapper;

    public function __construct(EportalSubjectUserMapperInterface $eportalSubjectUserMapper) {
        $this->eportalSubjectUserMapper = $eportalSubjectUserMapper;
    }

    public function addUser($user, $session, $term, $school, $class, $department, $subject) {
        return $this->eportalSubjectUserMapper->addUser($user, $session, $term, $school, $class, $department, $subject);
    }

    public function getUsers($session, $term, $school, $class, $department, $subject, $role = null) {
        return $this->eportalSubjectUserMapper->getUsers($session, $term, $school, $class, $department, $subject, $role);
    }
    
    public function getSubjects($user, $session, $term) {
        return $this->eportalSubjectUserMapper->getSubjects($user, $session, $term);
    }

    public function getUnregisteredUsers($session, $term, $school, $class, $department, $subject, $role = null) {
        return $this->eportalSubjectUserMapper->getUnregisteredUsers($session, $term, $school, $class, $department, $subject, $role);
    }

    public function removeUser($user, $session, $term, $school, $class, $department, $subject) {
        return $this->eportalSubjectUserMapper->removeUser($user, $session, $term, $school, $class, $department, $subject);
    }

}
