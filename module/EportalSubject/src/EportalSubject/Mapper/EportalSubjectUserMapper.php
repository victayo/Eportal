<?php

namespace EportalSubject\Mapper;

use EportalProperty\Mapper\AbstractEportalPropertyUserMapper;

/**
 * @author OKALA
 */
class EportalSubjectUserMapper extends AbstractEportalPropertyUserMapper implements EportalSubjectUserMapperInterface {

    /**
     *
     * @var EportalSubjectMapperInterface
     */
    protected $eportalSubjectMapper;

    public function __construct(EportalSubjectMapperInterface $eportalSubjectMapper) {
        $this->eportalSubjectMapper = $eportalSubjectMapper;
    }

    public function addUser($user, $session, $term, $school, $class, $department, $subject) {
        $rpv = $this->eportalSubjectMapper->getRelPropertyValue($school, $class, $department, $subject);
        return $this->addUserHelper($user, $session, $term, $rpv);
    }

    public function getUsers($session, $term, $school, $class, $department, $subject, $role = 'student') {
        $rpv = $this->eportalSubjectMapper->getRelPropertyValue($school, $class, $department, $subject);
        return $this->getUsersHelper($session, $term, $rpv, $role);
    }

    public function getUnregisteredUsers($session, $term, $school, $class, $department, $subject, $role) {
        $rpv = $this->eportalSubjectMapper->getRelPropertyValue($school, $class, $department, $subject);
        if(!$rpv){
            return false;
        }
        return $this->getUnregisteredUsersHelper($session, $term, $rpv, $role);
    }

    public function removeUser($user, $session, $term, $school, $class, $department, $subject) {
        $rpv = $this->eportalSubjectMapper->getRelPropertyValue($school, $class, $department, $subject);
        return $this->removeUserHelper($user, $session, $term, $rpv);
    }

    public function getSubjects($user, $session, $term){
        return $this->getUserProperty($user, $session, $term, self::EPORTAL_SUBJECT);
    }
}
