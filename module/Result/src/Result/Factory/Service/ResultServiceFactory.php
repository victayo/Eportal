<?php

namespace Result\Factory\Service;

use Result\Service\ResultService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class ResultServiceFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = $serviceLocator->get('Result\Mapper\Result');
        return new ResultService($mapper);
    }

}
