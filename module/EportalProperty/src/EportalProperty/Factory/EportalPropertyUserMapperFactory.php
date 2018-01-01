<?php

namespace EportalProperty\Factory;

use EportalProperty\Mapper\EportalPropertyUserMapper;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class EportalPropertyUserMapperFactory extends AbstractEportalPropertyUserMapperFactory{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = new EportalPropertyUserMapper();
        return $this->init($mapper, $serviceLocator);
    }

}
