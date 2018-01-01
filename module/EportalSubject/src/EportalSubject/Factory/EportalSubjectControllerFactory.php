<?php

namespace EportalSubject\Factory;

use EportalSubject\Controller\EportalSubjectController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class EportalSubjectControllerFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new EportalSubjectController($serviceLocator->getServiceLocator()->get('EportalSubject\Service\EportalSubject'));
    }

}
