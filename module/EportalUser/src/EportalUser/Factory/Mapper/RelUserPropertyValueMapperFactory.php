<?php

namespace EportalUser\Factory\Mapper;

use EportalUser\Mapper\RelUserPropertyValueMapper;
use EportalUser\Model\RelUserPropertyValue;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class RelUserPropertyValueMapperFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = new RelUserPropertyValueMapper();
        $propertyValueMapper = $serviceLocator->get('EportalProperty\Service\EportalPropertyValue')
                ->getPropertyValueService()
                ->getPropertyValueMapper();
        $mapper->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
                ->setEntityPrototype(new RelUserPropertyValue())
                ->setHydrator(new ClassMethods())
                ->setPropertyValueHydrator($propertyValueMapper->getHydrator())
                ->setPropertyValueEntity($propertyValueMapper->getEntityPrototype())
                ->setPropertyValueTable($propertyValueMapper->getTableName());
        return $mapper;
    }

}
