<?php

namespace Eportal\Factory\Controller;

use Eportal\Controller\StudentController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class StudentControllerFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $service = $serviceLocator->getServiceLocator()->get('EportalProperty\Service\EportalPropertyUser');
        return new StudentController($service);
    }

}
