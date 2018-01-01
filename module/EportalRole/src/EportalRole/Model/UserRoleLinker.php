<?php

namespace EportalRole\Model;

/**
 *
 * @author imaleo
 */
class UserRoleLinker {

    protected $user;
    protected $role;

    public function __construct($user = null, $role = null) {
        $this->user = $user;
        $this->role = $role;
    }

    public function exchangeArray($data) {
        $this->setUser(!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->setRole (!empty($data['role_id'])) ? $data['role_id'] : null;
    }
    
    public function getUser() {
        return $this->user;
    }

    public function getRole() {
        return $this->role;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }


}
