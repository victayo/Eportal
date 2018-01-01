<?php

namespace EportalDepartment\Service;

use EportalDepartment\Mapper\EportalDepartmentUserMapperInterface;

/**
 * @author OKALA
 */
class EportalDepartmentUserService implements EportalDepartmentUserServiceInterface{
    /**
     *
     * @var EportalDepartmentUserMapperInterface
     */
    protected $eportalDepartmentUserMapper;
    
    public function __construct(EportalDepartmentUserMapperInterface $eportalDepartmentUserMapper) {
        $this->eportalDepartmentUserMapper = $eportalDepartmentUserMapper;
    }

    public function addUser($user, $session, $term, $school, $class, $department, $addSubjects = true) {
        return $this->eportalDepartmentUserMapper->addUser($user, $session, $term, $school, $class, $department, $addSubjects);
    }

    public function getUsers($session, $term, $school, $class, $department, $role = null) {
        return $this->eportalDepartmentUserMapper->getUsers($session, $term, $school, $class, $department, $role);
    }
    
    public function getUnregisteredUsers($session, $term, $school, $class, $department, $role = null){
        return $this->eportalDepartmentUserMapper->getUnregisteredUsers($session, $term, $school, $class, $department, $role);
    }

    public function removeUser($user, $session, $term, $school, $class, $department) {
        return $this->eportalDepartmentUserMapper->removeUser($user, $session, $term, $school, $class, $department);
    }

}
