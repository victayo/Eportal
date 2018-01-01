<?php
namespace EportalUser\Model;

/**
 *
 * @author imaleo
 *        
 */
class UserSessionTerm implements UserSessionTermInterface
{
    protected $user;
    
    protected $session;
    
    protected $term;
    
    protected $id;

    public function __construct($id = null, $user = null, $session = null, $term = null) {
        $this->id = $id;
        $this->session = $session;
        $this->term = $term;
        $this->user = $user;
    }

    /**
     *
     * @see \EportalUser\Model\UserSessionTermInterface::getUser()
     *
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @see \EportalUser\Model\UserSessionTermInterface::getJointPropertyValue()
     *
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     *
     * @see \EportalUser\Model\UserSessionTermInterface::setUser()
     *
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     *
     * @see \EportalUser\Model\UserSessionTermInterface::setJointPropertyValue()
     *
     */
    public function setSession($jpv)
    {
        $this->session = $jpv;
        return $this;
    }

    /**
     *
     * @see \EportalUser\Model\UserSessionTermInterface::setId()
     *
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @see \EportalUser\Model\UserSessionTermInterface::getId()
     *
     */
    public function getId()
    {
        return $this->id;
    }

    public function getTerm() {
        return $this->term;
    }

    public function setTerm($term) {
        $this->term = $term;
        return $this;
    }

}
