<?php

namespace EportalUser\Factory\Service;

use EportalUser\Service\EportalUserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class EportalUserServiceFactory implements FactoryInterface {
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = $serviceLocator->get('EportalUser\Mapper\EportalUser');
        return new EportalUserService($mapper);
    }

}
