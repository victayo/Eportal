<?php

namespace EportalSetting\Service;

/**
 *
 * @author imaleo
 */
class PropertyValueOrderSet {
    protected $propertyValueOrders;
    protected $name;
    
    public function __construct($name = null, array $propertyValueOrders = array()) {
        $this->name = $name;
        $this->propertyValueOrders = $propertyValueOrders;
    }
    
    public function setOrder($propertyValue, $order){
        foreach($this->propertyValueOrders as $pvo){
            if($pvo->getRelPropertyValue() == $propertyValue){
                $pvo->setOrder($order);
                $this->sort();
                return true;
            }
        }
        return false;
    }
    
    public function getOrder($propertyValue){
        foreach($this->propertyValueOrders as $pvo){
            if($pvo->getRelPropertyValue() == $propertyValue){
                return $pvo->getOrder();
            }
        }
        return null;
    }
    
    public function addPropertyValueOrder($propertyValueOrder){
        if($this->hasPropertyValueOrder($propertyValueOrder)){
            return null;
        }
        $this->propertyValueOrders[] = $propertyValueOrder;
        $this->sort();
        return $this;
    }
    
    public function hasPropertyValueOrder($propertyValueOrder){
        foreach($this->propertyValueOrders as $pvo){
            if($pvo->getRelPropertyValue() == $propertyValueOrder->getRelPropertyValue()){
                return true;
            }
        }
        return false;
    }
    
    public function removePropertyValueOrder($propertyValue){
        foreach ($this->propertyValueOrders as $key => $pvo) {
            if($pvo->getRelPropertyValue() == $propertyValue){
                unset($this->propertyValueOrders[$key]);
                $this->sort();
                return true;
            }
        }
        return false;
    }

    public function getPropertyValueOrders() {
        return $this->propertyValueOrders;
    }

    public function getName() {
        return $this->name;
    }

    public function setPropertyValueOrders(array $propertyValueOrders) {
        $this->propertyValueOrders = $propertyValueOrders;
        $this->sort();
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
   
    public function getSortedPropertyValues($propertyValues){//PropertyValues from database
        $pvs = [];
        foreach($this->propertyValueOrders as $pvo){
            $pv = $this->getPropertyValue($propertyValues, $pvo->getRelPropertyValue());
            if($pv){
                $pvs[] = $pv;
            }
        }
        return $pvs;
    }
    
    public function sort(){
        usort($this->propertyValueOrders, array(PropertyValueOrder::class, 'compare'));
    }
    
    protected function getPropertyValue($propertyValues, $pvId){
        foreach ($propertyValues as $pv){
            if($pv->getId() == $pvId){
                return $pv;
            }
        }
        return null;
    }
    
}
