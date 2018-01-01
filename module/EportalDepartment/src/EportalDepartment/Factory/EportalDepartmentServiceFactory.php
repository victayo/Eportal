<?php

namespace EportalDepartment\Factory;

use EportalDepartment\Service\EportalDepartmentService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of EportalDepartmentServiceFactory
 *
 * @author OKALA
 */
class EportalDepartmentServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalDepartmentMapper = $serviceLocator->get('EportalDepartment\Mapper\EportalDepartment');
        $propertyValueService = $serviceLocator->get('Property\Service\PropertyValue');
        $propertyService = $serviceLocator->get('Property\Service\Property');
        return new EportalDepartmentService($eportalDepartmentMapper, $propertyValueService, $propertyService);
    }
}
