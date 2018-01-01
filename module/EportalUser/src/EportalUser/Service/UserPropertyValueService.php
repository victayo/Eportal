<?php
namespace EportalUser\Service;

use EportalProperty\Service\EportalPropertyServiceInterface;
use EportalUser\Mapper\UserPropertyValueMapperInterface;
use EportalUser\Model\EportalUserInterface;
use EportalUser\Model\UserRelPropertyValue;
use EportalUser\Model\UserRelPropertyValueInterface;
use Property\Model\PropertyValueInterface;

/**
 *
 * @author imaleo
 *        
 */
class UserPropertyValueService implements UserPropertyValueServiceInterface
{

    /**
     *
     * @var UserPropertyValueMapperInterface
     */
    protected $mapper;

    
    /**
     *
     * @var EportalPropertyServiceInterface
     */
    protected $eportalPropertyService;
    
    public function __construct(UserPropertyValueMapperInterface $mapper, EportalPropertyServiceInterface $eportalProperty)
    {
        $this->mapper = $mapper;
        $this->eportalPropertyService = $eportalProperty;
    }

    /**
     *
     * @see \EportalUser\Service\UserPropertyValueInterface::getClass()
     *
     */
    public function getClass(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term)
    {
        return $this->getPropertyValues($user, $session, $term, 'class');
    }

    /**
     *
     * @see \EportalUser\Service\UserPropertyValueInterface::getSchool()
     *
     */
    public function getSchool(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term)
    {
        return $this->getPropertyValues($user, $session, $term, 'school');
    }

    /**
     *
     * @see \EportalUser\Service\UserPropertyValueInterface::getSection()
     *
     */
    public function getSection(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term)
    {
        return $this->getPropertyValues($user, $session, $term, 'section');
    }

    /**
     *
     * @see \EportalUser\Service\UserPropertyValueInterface::getSubjects()
     *
     */
    public function getSubjects(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term)
    {
        return $this->getPropertyValues($user, $session, $term, 'subject');
    }

    /**
     *
     * @see \EportalUser\Service\UserPropertyValueInterface::getDepartment()
     *
     */
    public function getDepartment(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term)
    {
        return $this->getPropertyValues($user, $session, $term, 'department');
    }

    /**
     *
     * @see \EportalUser\Service\UserPropertyValueInterface::getPropertyValues()
     *
     */
    public function getPropertyValues(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term, $property = null)
    {
        if ($property) {
            $property = $this->eportalPropertyService
                    ->getPropertyService()
                    ->findByName(strtolower($property))
                    ->getId();
        }
        return $this->mapper->getPropertyValues($user->getId(), $session->getId(), $term->getId(), $property);
    }

    /**
     *
     * @see \EportalUser\Service\UserPropertyValueInterface::hasPropertyValue()
     *
     */
    public function getUserPropertyValue(EportalUserInterface $user, PropertyValueInterface $session, PropertyValueInterface $term, $propertyValue)
    {
        return $this->mapper->getUserPropertyValue($user->getId(), $propertyValue, $session->getId(), $term->getId())->current();
    }

    public function hasUserpropertyValue($user, $session, $term, $propertyValue) {
        return boolval($this->mapper->getUserPropertyValue($user, $session, $term, $propertyValue)->count());
    }
    /**
     *
     * @see \EportalUser\Service\UserPropertyValueInterface::getUsers()
     *
     */
    public function getUsers(PropertyValueInterface $session, PropertyValueInterface $term, $propertyValue, $role = null)
    {
        return $this->mapper->getUsers($session->getId(), $term->getId(), $propertyValue, $role);
    }
    
    public function setUserPropertyValueMapper(UserPropertyValueMapperInterface $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }
    
    public function getUserPropertyValueMapper()
    {
        return $this->mapper;
    }

    public function delete(UserRelPropertyValueInterface $upv, $where = null) {
        if(!$where){
            $where = array('id = ?' => $upv->getId());
        }
        return $this->mapper->delete($where);
    }

    public function insert(UserRelPropertyValueInterface $upv) {
        return $this->mapper->insert($upv);
    }

    public function update(UserRelPropertyValueInterface $upv, $where = null) {
        if(!$where){
            $where = array(
                'id = ?' => $upv->getId()
            );
        }
        return $this->mapper->update($upv, $where);
    }

    /**
     * 
     * @return UserRelPropertyValue
     */
    public function getEntity($id = null, $propertyValue = null, $userSessionTerm = null) {
        return new UserRelPropertyValue($id, $propertyValue, $userSessionTerm);
    }
    
    public function getEportalPropertyService() {
        return $this->eportalPropertyService;
    }

    public function setEportalPropertyService(EportalPropertyServiceInterface $eportalPropertyService) {
        $this->eportalPropertyService = $eportalPropertyService;
        return $this;
    }


}
