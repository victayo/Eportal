<?php

namespace Result\Factory\Service;

use Result\Service\AssessmentService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class AssessmentServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = $serviceLocator->get('Result\Mapper\Assessment');
        $assessment = new AssessmentService($mapper);
        return $assessment;
    }

}
