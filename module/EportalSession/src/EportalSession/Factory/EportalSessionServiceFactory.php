<?php

namespace EportalSession\Factory;

use EportalSession\Service\EportalSessionService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class EportalSessionServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalSessionMapper = $serviceLocator->get('EportalSession\Mapper\EportalSession');
        $propertyValueService = $serviceLocator->get('Property\Service\PropertyValue');
        $propertyService = $serviceLocator->get('Property\Service\Property');
        return new EportalSessionService($eportalSessionMapper, $propertyValueService, $propertyService);
    }

}
