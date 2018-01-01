<?php

namespace EportalUserTest\Mapper;

use EportalUser\Mapper\RelUserPropertyValueMapper;
use EportalUser\Model\RelUserPropertyValue;
use Property\Model\PropertyValue;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class RelUserPropertyValueMapperTest extends AbstractUserTestCase {

    protected $mapper;

    public function setup() {
        $propertyValueEntity = $this->getMockBuilder('\Property\Model\PropertyValue')
                ->setMethods(null)
                ->getMock();
        $adapter = $this->getAdapter();
        $this->mapper = new RelUserPropertyValueMapper();
        $this->mapper->setDbAdapter($adapter)
                ->setEntityPrototype(new RelUserPropertyValue())
                ->setHydrator(new ClassMethods())
                ->setPropertyValueHydrator(new ClassMethods())
                ->setPropertyValueEntity(new PropertyValue());
    }

    public function testGetSubCategories() {
        $user = 41;
        $sessionTerm = 55;
        $propertyValue = 1;
        $results = $this->mapper->getSubcategories($user, $sessionTerm, $propertyValue);
        foreach ($results as $result) {
            var_dump($result);
        }
        $this->assertNotNull($results);
    }

    public function testGetAllSubCategories(){
        $user = 41;
        $sessionTerm = 55;
        $propertyValue = 1;
        $results = $this->mapper->getAllSubcategories($user, $sessionTerm, $propertyValue);
//        var_dump($results);
        foreach ($results as $result){
            var_dump($result);
        }
        $this->assertNotNull($results);
    }
    
    

}
