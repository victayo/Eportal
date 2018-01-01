<?php

namespace EportalClass\Factory;

use EportalClass\Mapper\EportalClassUserMapper;
use EportalProperty\Factory\AbstractEportalPropertyUserMapperFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class EportalClassUserMapperFactory extends AbstractEportalPropertyUserMapperFactory{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalClassMapper = $serviceLocator->get('EportalClass\Mapper\EportalClass');
        $mapper = new EportalClassUserMapper($eportalClassMapper);
        return $this->init($mapper, $serviceLocator);
    }

}
