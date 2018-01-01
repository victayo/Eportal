<?php
namespace EportalUser\Service;

use EportalUser\Model\EportalUserInterface;
use EportalUser\Model\UserRelPropertyValueInterface;
use Property\Model\PropertyValueInterface;

/**
 *
 * @author imaleo
 *        
 */
interface UserPropertyValueServiceInterface
{
    /**
     * @return UserRelPropertyValueInterface
     */
    public function getEntity();
    
    public function insert(UserRelPropertyValueInterface $entity);
    
    public function update(UserRelPropertyValueInterface $entity, $where );
    
    public function delete(UserRelPropertyValueInterface $entity, $where);
    
    public function getUsers(PropertyValueInterface $session, PropertyValueInterface $term, $propertyValue, $role = null);
    
    public function getPropertyValues(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term, $property);
    
    public function getUserPropertyValue(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term, $propertyValue);
    
    public function hasUserpropertyValue($user, $session, $term, $propertyValue);

    public function getSubjects(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term);
    
    public function getSection(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term);
    
    public function getDepartment(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term);
    
    public function getSchool(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term);
    
    public function getClass(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term);
}
