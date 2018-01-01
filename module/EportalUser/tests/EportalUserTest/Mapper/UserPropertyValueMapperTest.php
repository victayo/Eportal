<?php

namespace EportalUserTest\Mapper;

use EportalUser\Mapper\UserPropertyValueMapper;
use EportalUser\Model\EportalUser;
use EportalUser\Model\UserRelPropertyValue;
use Property\Model\PropertyValue;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class UserPropertyValueMapperTest extends AbstractUserTestCase{
    
    protected $mapper;
    
    public function setUp(){
        $this->mapper = new UserPropertyValueMapper();
        $this->mapper->setDbAdapter($this->getAdapter())
                ->setEntityPrototype(new UserRelPropertyValue())
                ->setHydrator(new ClassMethods())
                ->setPropertyValueHydrator(new ClassMethods())
                ->setEportalUserHydrator(new ClassMethods())
                ->setEportalUserEntity(new EportalUser())
                ->setPropertyValueEntity(new PropertyValue());
    }
    
    public function testGetUser(){
        $session = 40;
        $term = 45;
        $pv = array(1, 13);
        $users = $this->mapper->getUsers($session, $term, $pv);
//        var_dump($users);
        foreach ($users as $user){
            var_dump($user);
        }
        $this->assertNotNull($users);
    }
}
