<?php

namespace EportalTerm\Factory;

use EportalTerm\Controller\EportalTermController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class EportalTermControllerFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new EportalTermController($serviceLocator->getServiceLocator()->get('EportalTerm\Service\EportalTerm'));
    }

}
