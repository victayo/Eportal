<?php

namespace EportalUser\Factory\Mapper;

use EportalUser\Mapper\EportalUserMapper;
use EportalUser\Model\EportalUser;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class EportalUserMapperFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = new EportalUserMapper();
        $mapper->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
                ->setEntityPrototype(new EportalUser())
                ->setHydrator($serviceLocator->get('EportalUser\Hydrator'));
        return $mapper;
    }

}
