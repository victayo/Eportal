<?php

namespace EportalSettingTest\Service;

use EportalSetting\Service\PropertyValueOrder;

/**
 *
 * @author imaleo
 */
class PropertyValueOrderTest extends \PHPUnit_Framework_TestCase{
    
    public function testSerialize(){
        $pvo = new PropertyValueOrder(1, 3);
        $ser = serialize($pvo);
        var_dump($ser);
        $unser = unserialize($ser);
        var_dump($unser);
        var_dump($unser->getOrder());
    }
}
