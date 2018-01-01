<?php

namespace EportalDepartment\Factory;

use EportalDepartment\Service\EportalDepartmentUserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class EportalDepartmentUserServiceFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new EportalDepartmentUserService($serviceLocator->get('EportalDepartment\Mapper\EportalDepartmentUser'));
    }

}
