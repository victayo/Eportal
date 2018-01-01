<?php

namespace EportalSchool\Factory;

use EportalSchool\Mapper\EportalSchoolMapper;
use Property\Factory\Mapper\AbstractRelPropertyValueMapperFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class EportalSchoolMapperFactory extends AbstractRelPropertyValueMapperFactory{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = new EportalSchoolMapper();
        $this->init($mapper, $serviceLocator);
        return $mapper;
    }

}
