<?php

namespace Result\Service;

use Result\Model\ResultInterface;
/**
 *
 * @author imaleo
 *        
 */
interface ResultServiceInterface
{
    /**
     * 
     * @param unknown $user
     * @param unknown $session
     * @param unknown $term
     * @param unknown $subject
     * @return ResultInterface
     */
    public function getResult($user, $session, $term, $subject);
    
    public function getEntity();
    
    public function getTerm($user, $session, $subject);
    
    public function getSubjects($user, $session, $term);
    
    public function hasSubject($user, $session, $term, $subject);
    
    public function getUsers($session, $term, $subject);
    
    public function findById($result_id);
    
    public function insert(ResultInterface $result);
    
    public function update(ResultInterface $result, $where = null);
    
    public function delete(ResultInterface $result, $where = null);
}

