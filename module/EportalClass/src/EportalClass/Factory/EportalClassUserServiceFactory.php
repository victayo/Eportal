<?php


namespace EportalClass\Factory;

use EportalClass\Service\EportalClassUserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class EportalClassUserServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new EportalClassUserService($serviceLocator->get('EportalClass\Mapper\EportalClassUser'));
    }

}
