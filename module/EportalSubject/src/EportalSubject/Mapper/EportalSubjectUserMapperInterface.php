<?php

namespace EportalSubject\Mapper;

/**
 * @author OKALA
 */
interface EportalSubjectUserMapperInterface {
    public function getUsers($session, $term, $school, $class, $department, $subject, $role);

    public function getUnregisteredUsers($session, $term, $school, $class, $department, $subject, $role);
    
    public function addUser($user, $session, $term, $school, $class, $department, $subject);

    public function removeUser($user, $session, $term, $school, $class, $department, $subject);
    
    public function getSubjects($user, $session, $term);
}
