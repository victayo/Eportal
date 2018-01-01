<?php

namespace EportalSchool\Factory;

use EportalSchool\Controller\EportalSchoolController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class EportalSchoolControllerFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalSchoolService = $serviceLocator->getServiceLocator()->get('EportalSchool\Service\EportalSchool');
        return new EportalSchoolController($eportalSchoolService);
    }

}
