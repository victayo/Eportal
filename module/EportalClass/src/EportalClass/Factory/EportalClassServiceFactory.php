<?php

namespace EportalClass\Factory;

use EportalClass\Service\EportalClassService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of EportalClassServiceFactory
 *
 * @author OKALA
 */
class EportalClassServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalClassMapper = $serviceLocator->get('EportalClass\Mapper\EportalClass');
        $propertyValueService = $serviceLocator->get('Property\Service\PropertyValue');
        $propertyService = $serviceLocator->get('Property\Service\Property');
        return new EportalClassService($eportalClassMapper, $propertyValueService, $propertyService);
    }
}
