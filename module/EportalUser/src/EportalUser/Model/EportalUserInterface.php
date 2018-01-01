<?php

namespace EportalUser\Model;

use ZfcUser\Entity\UserInterface;

/**
 *
 * @author imaleo
 *        
 */
interface EportalUserInterface extends UserInterface {

    public function getFirstName();

    public function setFirstName($firstName);

    public function getMiddleName();

    public function setMiddleName($middleName);

    public function getLastName();

    public function setLastName($lastName);

    public function getGender();

    public function setGender($gender);

    public function getDob();

    public function setDob($dob);
    
    public function getStatus();
    
    public function setStatus($status);
}
