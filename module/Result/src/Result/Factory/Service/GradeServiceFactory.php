<?php

namespace Result\Factory\Service;

use Result\Service\GradeService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class GradeServiceFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = $serviceLocator->get('Result\Mapper\Grade');
        return new GradeService($mapper);
    }

}
