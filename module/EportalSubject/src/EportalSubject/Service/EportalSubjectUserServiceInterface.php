<?php

namespace EportalSubject\Service;

/**
 * @author OKALA
 */
interface EportalSubjectUserServiceInterface {
    public function getUsers($session, $term, $school, $class, $department, $subject, $role);
    
    public function getSubjects($user, $session, $term);

    public function getUnregisteredUsers($session, $term, $school, $class, $department, $subject, $role);
    
    public function addUser($user, $session, $term, $school, $class, $department, $subject);

    public function removeUser($user, $session, $term, $school, $class, $department, $subject);
}
