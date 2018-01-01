<?php



namespace EportalClass\Mapper;

/**
 * @author OKALA
 */
interface EportalClassUserMapperInterface {
public function getUsers($session, $term, $school, $class, $role);

public function getUnregisteredUsers($session, $term, $school, $class, $role);

public function addUser($user, $session, $term, $school, $class, $addSubjects = true);

public function removeUser($user, $session, $term, $school, $class);
}
