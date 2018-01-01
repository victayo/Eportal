<?php

namespace EportalPropertyTest\Service;

use EportalProperty\Service\EportalRelPropertyValueService;
use Property\Model\PropertyValue;
use Property\Model\Property;
/**
 *
 * @author imaleo
 */
class EportalJointPropertyValueServiceTest extends \PHPUnit_Framework_TestCase{
    
    protected $ejpvs;
    protected $settingService;
    protected $propertyService;
    protected $jpvService;
    
    public function setUp(){
        $this->settingService = $this->getMockBuilder('EportalSetting\Service\EportalSettingService')
                ->disableOriginalConstructor()
                ->getMock();
        $this->propertyService = $this->getMockBuilder('Property\Service\PropertyService')
                ->disableOriginalConstructor()
                ->getMock();
        $this->jpvService = $this->getMockBuilder('Property\Service\JointPropertyValueService')
                ->disableOriginalConstructor()
                ->getMock();
        $this->ejpvs = new EportalRelPropertyValueService($this->settingService, $this->jpvService, $this->propertyService);
    }
    
    public function testGetSessionTerms(){
        $session = new PropertyValue();
        $expected_result = $this->getPropertyValuesArray('term');
        $this->propertyService->expects($this->once())
                ->method('findByName')
                ->will($this->returnValue(new Property(null,'term')));
        $this->jpvService->expects($this->once())
                ->method('findSecondPropertyValue')
                ->will($this->returnValue($expected_result));
        $this->settingService->expects($this->once())
                ->method('sort')
                ->will($this->returnValue($expected_result));
        $actual_result = $this->ejpvs->getSessionTerms($session);
        $this->assertEquals($actual_result, $expected_result);
    }
    
    protected function getPropertyValuesArray($property, $qty = 3){
        $pvs = [];
        for($i = 0; $i < $qty; $i++){
            $prop = new Property(null, $property);
            $pvs[] = new PropertyValue($i, $property.'_'.$i, $prop);
        }
        return $pvs;
    }
}
