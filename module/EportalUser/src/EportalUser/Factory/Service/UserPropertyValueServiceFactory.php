<?php

namespace EportalUser\Factory\Service;

use EportalUser\Service\UserPropertyValueService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class UserPropertyValueServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = $serviceLocator->get('EportalUser\Mapper\UserPropertyValue');
        $eportalProp = $serviceLocator->get('EportalProperty\Service\EportalProperty');
        return new UserPropertyValueService($mapper, $eportalProp);
    }

}
