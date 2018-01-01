<?php

namespace EportalSession\Factory;

use EportalSession\Mapper\EportalSessionMapper;
use Property\Factory\Mapper\AbstractRelPropertyValueMapperFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 *
 * @author imaleo
 */
class EportalSessionMapperFactory extends AbstractRelPropertyValueMapperFactory{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = new EportalSessionMapper();
        $this->init($mapper, $serviceLocator);
        return $mapper;
    }

}
