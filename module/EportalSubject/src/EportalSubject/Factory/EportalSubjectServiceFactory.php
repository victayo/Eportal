<?php

namespace EportalSubject\Factory;

use EportalSubject\Service\EportalSubjectService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of EportalSubjectServiceFactory
 *
 * @author OKALA
 */
class EportalSubjectServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalSubjectMapper = $serviceLocator->get('EportalSubject\Mapper\EportalSubject');
        $propertyValueService = $serviceLocator->get('Property\Service\PropertyValue');
        $propertyService = $serviceLocator->get('Property\Service\Property');
        return new EportalSubjectService($eportalSubjectMapper, $propertyValueService, $propertyService);
    }
}
