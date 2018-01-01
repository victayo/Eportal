<?php

namespace EportalSettingTest\Service;

use EportalSetting\Service\PropertyValueOrder;
use EportalSetting\Service\PropertyValueOrderSet;
use Property\Model\Property;
use Property\Model\PropertyValue;

/**
 *
 * @author imaleo
 */
class PropertyValueOrderSetTest extends \PHPUnit_Framework_TestCase{
    
    public function testSerialize(){
        $pvos = new PropertyValueOrderSet('test');
        $pvo1 = new PropertyValueOrder(10, 8);
        $pvo2 = new PropertyValueOrder(11, 2);
        $pvo3 = new PropertyValueOrder(34, 18);
        $pvos->addPropertyValueOrder($pvo1)
                ->addPropertyValueOrder($pvo2)
                ->addPropertyValueOrder($pvo3);
        $ser = serialize($pvos);
//        var_dump($ser);
        $unser = unserialize($ser);
        $pv1 = new PropertyValue(10, 'val_1', new Property());
        $pv2 = new PropertyValue(11, 'val_1', new Property());
        $pv3 = new PropertyValue(34, 'val_1', new Property());
        $pvs = [];
        $pvs[] = $pv1;
        $pvs[] = $pv2;
        $pvs[] = $pv3;
//        var_dump($unser->getPropertyValueOrders());
       $spvs = $unser->getSortedPropertyValues($pvs);
       foreach($spvs as $spv){
           var_dump($spv);
       }
//        var_dump($pvos->getPropertyValueOrders());
    }
    
    public function testGetPropertyValueOrders(){
        
    }
}
