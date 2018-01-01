<?php


namespace EportalTerm\Factory;

use EportalTerm\Mapper\EportalTermMapper;
use Property\Factory\Mapper\AbstractRelPropertyValueMapperFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of EportalTermMapperFactory
 *
 * @author OKALA
 */
class EportalTermMapperFactory extends AbstractRelPropertyValueMapperFactory{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = new EportalTermMapper();
        $this->init($mapper, $serviceLocator);
        return $mapper;
    }
}
