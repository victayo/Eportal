<?php

namespace EportalUser\Form\Model;

use EportalProperty\Model\EportalProperty;

/**
 *
 * @author imaleo
 */
class UserUpload extends EportalProperty{
    protected $users;
    
    public function getUsers() {
        return $this->users;
    }

    public function setUsers($users) {
        $this->users = $users;
        return $this;
    }
}
