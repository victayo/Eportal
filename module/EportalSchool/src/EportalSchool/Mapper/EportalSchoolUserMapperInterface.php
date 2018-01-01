<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace EportalSchool\Mapper;

/**
 * @author OKALA
 */
interface EportalSchoolUserMapperInterface {
public function addUser($user, $session, $term, $school);

public function getUsers($session, $term, $school, $role);

public function removeUser($user, $session, $term, $school);
}
