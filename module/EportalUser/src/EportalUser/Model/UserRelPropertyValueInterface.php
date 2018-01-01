<?php
namespace EportalUser\Model;

/**
 *
 * @author imaleo
 *        
 */
interface UserRelPropertyValueInterface
{

    public function getId();

    /**
     * 
     * @return UserRelPropertyValueInterface
     */
    public function setId($id);

    /**
     * 
     * @return UserRelPropertyValueInterface
     */
    public function setRelPropertyValue($propertyValue);

    public function getRelPropertyValue();

    public function getUserSessionTerm();

    /**
     * 
     * @return UserSessionTermInterface
     */
    public function setUserSessionTerm($ejpv);
}

