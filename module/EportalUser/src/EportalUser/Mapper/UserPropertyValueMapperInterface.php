<?php

namespace EportalUser\Mapper;

/**
 *
 * @author imaleo
 *        
 */
interface UserPropertyValueMapperInterface {

    public function insert($entity);

    public function update($entity);

    public function delete($where, $table);

    public function getUsers($session, $term, $propertyValue, $role = null);

    public function getPropertyValues($user, $session, $term, $property = null);

    public function getUserPropertyValue($user, $propertyValue, $session, $term);
}
