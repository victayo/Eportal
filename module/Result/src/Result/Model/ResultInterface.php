<?php
namespace Result\Model;

/**
 *
 * @author imaleo
 *        
 */
interface ResultInterface
{

    public function getId();

    public function setId($id);

    public function setUser($user);

    public function getUser();

    public function setSession($session);

    public function getSession();

    public function getTerm();

    public function setTerm($term);

    public function getDate();

    public function setDate($date);
    
    public function setSubject($subject);
    
    public function getSubject();
}

