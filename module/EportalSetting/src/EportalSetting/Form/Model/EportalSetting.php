<?php

namespace EportalSetting\Form\Model;

/**
 *
 * @author imaleo
 */
class EportalSetting {
    protected $property;
    
    public function getProperty() {
        return $this->property;
    }

    public function setProperty($property) {
        $this->property = $property;
        return $this;
    }
}
