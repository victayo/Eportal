<?php

namespace EportalSession\Factory;

use EportalSession\Controller\EportalSessionController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class EportalSessionControllerFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalSessionService = $serviceLocator->getServiceLocator()->get('EportalSession\Service\EportalSession');
        return new EportalSessionController($eportalSessionService);
    }

}
