<?php

namespace Result\Factory\Service;

use Result\Service\RemarkService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class RemarkServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = $serviceLocator->get('Result\Mapper\Remark');
        return new RemarkService($mapper);
    }

}
