<?php

namespace EportalUser\Factory\Mapper;

use EportalUser\Mapper\UserPropertyValueMapper;
use EportalUser\Model\UserRelPropertyValue;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class UserPropertyValueMapperFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = new UserPropertyValueMapper();
        $propertyValueMapper = $serviceLocator->get('EportalProperty\Service\EportalPropertyValue')
                ->getPropertyValueService()
                ->getPropertyValueMapper();
        $userMapper = $serviceLocator->get('EportalUser\Mapper\EportalUser');
        $mapper->setPropertyValueEntity($propertyValueMapper->getEntityPrototype())
                ->setPropertyValueTable($propertyValueMapper->getTableName())
                ->setPropertyValueHydrator($propertyValueMapper->getHydrator())
                ->setEportalUserEntity($userMapper->getEntityPrototype())
                ->setEportalUserHydrator($userMapper->getHydrator())
                ->setEportalUserTable($userMapper->getTableName())
                ->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
                ->setEntityPrototype(new UserRelPropertyValue())
                ->setHydrator(new ClassMethods());
        return $mapper;
    }

}
