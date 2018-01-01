<?php


namespace EportalDepartment\Factory;

use EportalDepartment\Mapper\EportalDepartmentMapper;
use Property\Factory\Mapper\AbstractRelPropertyValueMapperFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of EportalDepartmentMapperFactory
 *
 * @author OKALA
 */
class EportalDepartmentMapperFactory extends AbstractRelPropertyValueMapperFactory{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = new EportalDepartmentMapper();
        $this->init($mapper, $serviceLocator);
        return $mapper;
    }
}
