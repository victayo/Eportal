<?php

namespace EportalDepartment\Factory;

use EportalDepartment\Mapper\EportalDepartmentUserMapper;
use EportalProperty\Factory\AbstractEportalPropertyUserMapperFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class EportalDepartmentUserMapperFactory extends AbstractEportalPropertyUserMapperFactory{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalDepartmentMapper = $serviceLocator->get('EportalDepartment\Mapper\EportalDepartment');
        $mapper = new EportalDepartmentUserMapper($eportalDepartmentMapper);
        return $this->init($mapper, $serviceLocator);
    }

}
