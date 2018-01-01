<?php

namespace Property\Factory\Mapper;

use Property\Model\PropertyValue;
use Property\Model\RelPropertyValue;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 *        
 */
abstract class AbstractRelPropertyValueMapperFactory implements FactoryInterface {

    protected function init($mapper, ServiceLocatorInterface $serviceLocator){
        $mapper->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
                ->setHydrator(new ClassMethods())
                ->setEntityPrototype(new RelPropertyValue())
                ->setPropertyValueHydrator($serviceLocator->get('Property\Hydrator\PropertyValue'))
                ->setPropertyValueEntity(new PropertyValue())
                ->setTableName('rel_property_value');
        return $mapper;
    }
}
