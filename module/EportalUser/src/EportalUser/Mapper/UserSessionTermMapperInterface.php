<?php

namespace EportalUser\Mapper;


/**
 *
 * @author imaleo
 *        
 */
interface UserSessionTermMapperInterface
{
    public function insert($entity);
    
    public function update($entity);
    
    public function delete($where);
    
    public function findById($id);
    
    public function getUsers($session, $term, $role);
    
    public function getSessionTerms($user);
    
    public function getUserSessionTerm($user, $session, $term);

        public function exist($user, $session, $term);
}
