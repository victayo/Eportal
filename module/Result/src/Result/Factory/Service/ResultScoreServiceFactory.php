<?php

namespace Result\Factory\Service;

use Result\Service\ResultScoreService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class ResultScoreServiceFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = $serviceLocator->get('Result\Mapper\ResultScore');
        return new ResultScoreService($mapper);
    }

}
