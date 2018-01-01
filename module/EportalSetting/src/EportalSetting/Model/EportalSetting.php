<?php

namespace EportalSetting\Model;

/**
 *
 * @author imaleo
 */
class EportalSetting {
    protected $meta;
    protected $value;
    
    public function __construct($meta = null, $value = null) {
        $this->meta = $meta;
        $this->value = $value;
    }
    
    public function getMeta() {
        return $this->meta;
    }

    public function getValue() {
        return $this->value;
    }

    public function setMeta($meta) {
        $this->meta = $meta;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }


}
