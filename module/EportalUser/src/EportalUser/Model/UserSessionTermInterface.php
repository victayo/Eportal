<?php
namespace EportalUser\Model;

/**
 *
 * @author imaleo
 *        
 */
interface UserSessionTermInterface
{
    public function getId();

    /**
     * 
     * @return UserSessionTermInterface
     */
    public function setId($id);

    public function getUser();

    /**
     * 
     * @return UserSessionTermInterface
     */
    public function setUser($user);

    public function getSession();

    /**
     * 
     * @return UserSessionTermInterface
     */
    public function setSession($jpv);
    
    public function getTerm();
    
    /**
     * 
     * @return UserSessionTermInterface
     */
    public function setTerm($term);
}

