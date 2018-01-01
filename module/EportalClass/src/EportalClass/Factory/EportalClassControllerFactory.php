<?php


namespace EportalClass\Factory;

use EportalClass\Controller\EportalClassController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author OKALA
 */
class EportalClassControllerFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalClassService = $serviceLocator->getServiceLocator()->get('EportalClass\Service\EportalClass');
        return new EportalClassController($eportalClassService);
    }
}
