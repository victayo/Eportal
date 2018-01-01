<?php

namespace EportalDepartment\Service;

/**
 * @author OKALA
 */
interface EportalDepartmentUserServiceInterface {

    public function getUsers($session, $term, $school, $class, $department, $role);

    public function getUnregisteredUsers($session, $term, $school, $class, $department, $role);
    
    public function addUser($user, $session, $term, $school, $class, $department, $addSubjects = true);

    public function removeUser($user, $session, $term, $school, $class, $department);
}
