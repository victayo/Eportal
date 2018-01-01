<?php

namespace EportalSchool\Factory;

use EportalSchool\Service\EportalSchoolService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class EportalSchoolServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalSchoolMapper = $serviceLocator->get('EportalSchool\Mapper\EportalSchool');
        $propertyValueService = $serviceLocator->get('Property\Service\PropertyValue');
        $propertyService = $serviceLocator->get('Property\Service\Property');
        return new EportalSchoolService($eportalSchoolMapper, $propertyValueService, $propertyService);
    }

}
