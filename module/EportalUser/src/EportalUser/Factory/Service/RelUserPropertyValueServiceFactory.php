<?php

namespace EportalUser\Factory\Service;

use EportalUser\Service\RelUserPropertyValueService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class 
RelUserPropertyValueServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new RelUserPropertyValueService($serviceLocator->get('EportalUser\Mapper\RelUserPropertyValue'));
    }

}{
    
}
