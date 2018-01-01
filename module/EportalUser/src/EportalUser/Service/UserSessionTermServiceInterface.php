<?php

namespace EportalUser\Service;

use EportalUser\Model\UserSessionTermInterface;

/**
 *
 * @author imaleo
 */
interface UserSessionTermServiceInterface {
    /**
     * @return UserSessionTermInterface
     */
    public function getEntity();
    
//    public function getUserSessionTerm($user, $session, $term);
    
    public function insert(UserSessionTermInterface $entity);
    
    public function update(UserSessionTermInterface $entity);
    
    public function delete(UserSessionTermInterface $entity);
    
    public function findById($id);
    
    public function getUsers($session, $term, $role);
    
    public function getSessionTerms($user);
    
    public function getUserSessionTerm($user, $session, $term);
}
