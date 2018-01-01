<?php

namespace EportalSubject\Factory;

use EportalProperty\Factory\AbstractEportalPropertyUserMapperFactory;
use EportalSubject\Mapper\EportalSubjectUserMapper;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class EportalSubjectUserMapperFactory extends AbstractEportalPropertyUserMapperFactory {
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalSubjectMapper = $serviceLocator->get('EportalSubject\Mapper\EportalSubject');
        $mapper = new EportalSubjectUserMapper($eportalSubjectMapper);
        return $this->init($mapper, $serviceLocator);
    }

}
