<?php

namespace Result\Factory\Mapper\Hydrator;

use Result\Mapper\Hydrator\ResultScoreHydrator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class ResultScoreHydratorFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new ResultScoreHydrator($serviceLocator->get('Result\Service\Result'), $serviceLocator->get('Result\Service\Assessment'));
    }

}
