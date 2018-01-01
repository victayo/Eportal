<?php

namespace EportalUser\Factory\Mapper;

use EportalUser\Mapper\UserSessionTermMapper;
use EportalUser\Model\UserSessionTerm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class UserSessionTermMapperFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = new UserSessionTermMapper();
        $eportalUserMapper = $serviceLocator->get('EportalUser\Mapper\EportalUser');
        $mapper->setEportalUserEntity($eportalUserMapper->getEntityPrototype())
                ->setEportalUserHydrator($eportalUserMapper->getHydrator())
                ->setEportalUserTable($eportalUserMapper->getTableName())
                ->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
                ->setEntityPrototype(new UserSessionTerm())
                ->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
        return $mapper;
    }

}
