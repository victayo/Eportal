<?php

namespace EportalSubject\Factory;

use EportalSubject\Service\EportalSubjectUserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class EportalSubjectUserServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new EportalSubjectUserService($serviceLocator->get('EportalSubject\Mapper\EportalSubjectUser'));
    }

}
