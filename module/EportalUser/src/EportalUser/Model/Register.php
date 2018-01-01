<?php

namespace EportalUser\Model;

/**
 *
 * @author imaleo
 */
class Register {
    protected $user;
    protected $property;
    
    public function getUser() {
        return $this->user;
    }

    public function getProperty() {
        return $this->property;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function setProperty($property) {
        $this->property = $property;
        return $this;
    }


}
