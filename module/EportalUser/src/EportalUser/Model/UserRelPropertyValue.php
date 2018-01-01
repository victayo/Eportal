<?php
namespace EportalUser\Model;

/**
 *
 * @author imaleo
 *        
 */
class UserRelPropertyValue implements UserRelPropertyValueInterface
{
    protected $id;
    
    protected $relPropertyValue;
    
    protected $userSessionTerm;

    public function __construct($id = null, $propertyValue = null, $ust = null) {
        $this->id = $id;
        $this->relPropertyValue = $propertyValue;
        $this->userSessionTerm = $ust;
    }

    /**
     *
     * @see \EportalUser\Model\UserRelPropertyValueInterface::setPropertyValue()
     *
     */
    public function setRelPropertyValue($propertyValue)
    {
        $this->relPropertyValue = $propertyValue;
        return $this;
    }

    /**
     *
     * @see \EportalUser\Model\UserRelPropertyValueInterface::getEportalJointPropertyValue()
     *
     */
    public function getUserSessionTerm()
    {
        return $this->userSessionTerm;
    }

    /**
     *
     * @see \EportalUser\Model\UserRelPropertyValueInterface::getPropertyValue()
     *
     */
    public function getRelPropertyValue()
    {
        return $this->relPropertyValue;
    }

    /**
     *
     * @see \EportalUser\Model\UserRelPropertyValueInterface::setEportalJointPropertyValue()
     *
     */
    public function setUserSessionTerm($ust)
    {
        $this->userSessionTerm = $ust;
        return $this;
    }

    /**
     *
     * @see \EportalUser\Model\UserRelPropertyValueInterface::setId()
     *
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @see \EportalUser\Model\UserRelPropertyValueInterface::getId()
     *
     */
    public function getId()
    {
        return $this->id;
    }
}

?>