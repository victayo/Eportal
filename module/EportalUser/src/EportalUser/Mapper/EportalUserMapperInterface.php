<?php

namespace EportalUser\Mapper;

use ZfcUser\Mapper\UserInterface;

/**
 *
 * @author imaleo
 */
interface EportalUserMapperInterface extends UserInterface {
    public function findByGender($gender);
    public function findByStatus($status);
    public function getTotalUser($role = null);
    public function getTotalGender($gender, $role = null);
}
