<?php

namespace EportalSettingTest\Service;

use EportalSetting\Service\EportalSettingService;
use EportalSetting\Service\PropertyValueOrder;
use EportalSetting\Service\PropertyValueOrderSet;
use Property\Model\Property;
use Property\Model\PropertyValue;

/**
 *
 * @author imaleo
 */
class EportalSettingServiceTest extends \PHPUnit_Framework_TestCase{
    protected $mapper;
    protected $settingService;
    
    public function setUp(){
        $this->mapper = $this->getMockBuilder('EportalSetting\Mapper\EportalSettingMapper')
                ->disableOriginalConstructor()
                ->getMock();
        $this->settingService = new EportalSettingService($this->mapper);
    }
    
    public function testSort(){
        $propertyValues = array(10,11,34,23);
        $orders = array(8,2,18,3);
        $ids = array(10,34,23);
        $expected_result = array(23,10,34);
        $pvos = $this->getPropertyValueOrderSet($propertyValues, $orders);
        $ser = serialize($pvos);
        $this->mapper->expects($this->once())
                ->method('getMetaValue')
                ->will($this->returnValue($ser));
        $pvs = $this->getPropertyValues($ids);
        $result = $this->settingService->sort($pvs, 'test');
        $actual_result = $this->getPropertyValueId($result);
        $this->assertEquals($actual_result, $expected_result);
    }
    
    protected function getPropertyValueOrderSet($propertyValues, $orders) {
        $pvoSet = new PropertyValueOrderSet('test');
        for($i = 0, $l = count($propertyValues); $i < $l; $i++){
            $pvo = new PropertyValueOrder($propertyValues[$i], $orders[$i]);
            $pvoSet->addPropertyValueOrder($pvo);
        }
        return $pvoSet;
    }
    
    protected function getPropertyValues($ids){
        $pvs = [];
        foreach ($ids as $id) {
            $pv = new PropertyValue($id, 'val_'.$id, new Property());
            $pvs[] = $pv;
        }
        return $pvs;
    }
    
    protected function getPropertyValueId($propertyValues){
        $ids = [];
        foreach ($propertyValues as $pv){
            $ids[] = $pv->getId();
        }
        return $ids;
    }
}
