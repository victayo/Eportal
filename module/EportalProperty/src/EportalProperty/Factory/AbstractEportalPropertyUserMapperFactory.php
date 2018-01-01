<?php

namespace EportalProperty\Factory;

use EportalUser\Model\EportalUser;
use EportalUser\Model\UserRelPropertyValue;
use Property\Model\PropertyValue;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * @author OKALA
 */
abstract class AbstractEportalPropertyUserMapperFactory implements FactoryInterface{
    
    protected function init($mapper, ServiceLocatorInterface $serviceLocator){
        $mapper->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
                ->setEntityPrototype(new UserRelPropertyValue())
                ->setHydrator(new ClassMethods())
                ->setUserEntity(new EportalUser())
                ->setUserHydrator($serviceLocator->get('EportalUser\Hydrator'))
                ->setPropertyValueEntity(new PropertyValue())
                ->setPropertyValueHydrator($serviceLocator->get('Property\Hydrator\PropertyValue'))
                ->setTableName('user_rel_property_value')
                ->setUserSessionTermMapper($serviceLocator->get('EportalUser\Mapper\UserSessionTerm'));
        return $mapper;
    }

}
