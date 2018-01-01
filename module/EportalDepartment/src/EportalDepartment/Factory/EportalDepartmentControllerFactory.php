<?php


namespace EportalDepartment\Factory;

use EportalDepartment\Controller\EportalDepartmentController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author OKALA
 */
class EportalDepartmentControllerFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalDepartmentService = $serviceLocator->getServiceLocator()->get('EportalDepartment\Service\EportalDepartment');
        return new EportalDepartmentController($eportalDepartmentService);
    }
}
