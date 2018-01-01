<?php

namespace EportalUser\Factory\Service;

use EportalUser\Service\UserSessionTermService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class UserSessionTermServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = $serviceLocator->get('EportalUser\Mapper\UserSessionTerm');
        return new UserSessionTermService($mapper);
    }

}
