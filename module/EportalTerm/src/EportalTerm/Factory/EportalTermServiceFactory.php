<?php

namespace EportalTerm\Factory;

use EportalTerm\Service\EportalTermService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of EportalTermServiceFactory
 *
 * @author OKALA
 */
class EportalTermServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalTermMapper = $serviceLocator->get('EportalTerm\Mapper\EportalTerm');
        $propertyValueService = $serviceLocator->get('Property\Service\PropertyValue');
        $propertyService = $serviceLocator->get('Property\Service\Property');
        return new EportalTermService($eportalTermMapper, $propertyValueService, $propertyService);
    }
}
