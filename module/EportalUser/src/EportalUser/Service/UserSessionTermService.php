<?php

namespace EportalUser\Service;

use EportalUser\Mapper\UserSessionTermMapperInterface;
use EportalUser\Model\UserSessionTerm;
use EportalUser\Model\UserSessionTermInterface;

/**
 *
 * @author imaleo
 */
class UserSessionTermService implements UserSessionTermServiceInterface{
    
    protected $mapper;
    
    public function __construct(UserSessionTermMapperInterface $mapper) {
        $this->mapper = $mapper;
    }
    
    public function delete(UserSessionTermInterface $entity) {
        $where = array('id = ?' => $entity->getId());
        return $this->mapper->delete($where);
    }

    public function getUserSessionTerm($user, $session, $term) {
        return $this->mapper->getUserSessionTerm($user, $session, $term);
    }

    public function findById($id) {
        return $this->mapper->findById($id);
    }

    public function getSessionTerms($user) {
        return $this->mapper->getSessionTerms($user);
    }

    public function getUsers($session, $term, $role = null) {
        return $this->mapper->getUsers($session, $term, $role);
    }

    public function insert(UserSessionTermInterface $entity) {
        return $this->mapper->insert($entity);
    }

    public function update(UserSessionTermInterface $entity) {
        return$this->mapper->update($entity);
    }

    /**
     * 
     * @return \EportalUser\Service\EportalUser\Model\UserSessionTerm
     */
    public function getEntity($id = null, $user = null, $session = null, $term = null) {
        return new UserSessionTerm($id, $user, $session, $term);
    }
}
