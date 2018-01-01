<?php

namespace EportalSetting\Service;

/**
 *
 * @author imaleo
 */
class PropertyValueOrder {
    protected $propertyValue;
    protected $order;
    
    /**
     * 
     * @param int $propertyValue id
     * @param int $order
     */
    public function __construct($propertyValue = null, $order = null) {
        $this->propertyValue = $propertyValue;
        $this->order = $order;
    }
    
    public static function compare($pvo_a, $pvo_b){
        $ord_a = $pvo_a->getOrder();
        $ord_b = $pvo_b->getOrder();
        if($ord_a == $ord_b){
            return 0;
        }
        return ($ord_a > $ord_b) ? 1 : -1;
    }
    
    public function getPropertyValue() {
        return $this->propertyValue;
    }

    public function getOrder() {
        return $this->order;
    }

    public function setPropertyValue($propertyValue) {
        $this->propertyValue = $propertyValue;
        return $this;
    }

    public function setOrder($order) {
        $this->order = $order;
        return $this;
    }

    public function toArray(){
        return array(
            $this->propertyValue => $this->order
        );
    }
}
