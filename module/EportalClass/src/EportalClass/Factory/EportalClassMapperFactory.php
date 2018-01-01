<?php


namespace EportalClass\Factory;

use EportalClass\Mapper\EportalClassMapper;
use Property\Factory\Mapper\AbstractRelPropertyValueMapperFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of EportalClassMapperFactory
 *
 * @author OKALA
 */
class EportalClassMapperFactory extends AbstractRelPropertyValueMapperFactory{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = new EportalClassMapper();
        $this->init($mapper, $serviceLocator);
        return $mapper;
    }
}
