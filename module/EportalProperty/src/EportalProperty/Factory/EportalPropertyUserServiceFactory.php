<?php

namespace EportalProperty\Factory;

use EportalProperty\Service\EportalPropertyUserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class EportalPropertyUserServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new EportalPropertyUserService($serviceLocator->get('EportalProperty\Mapper\EportalPropertyUser'));
    }

}
