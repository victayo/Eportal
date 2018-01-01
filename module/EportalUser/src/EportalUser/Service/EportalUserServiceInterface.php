<?php

namespace EportalUser\Service;

use ZfcUser\Mapper\UserInterface;

/**
 *
 * @author imaleo
 */
interface EportalUserServiceInterface extends UserInterface{
    public function findByGender($gender);
    
    public function getEntity();
    
    public function findByStatus($status);
    
    public function getTotalGender($gender, $role = null);
    
    public function getTotalUser($role = null);
}
