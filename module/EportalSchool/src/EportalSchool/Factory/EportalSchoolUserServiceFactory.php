<?php



namespace EportalSchool\Factory;

use EportalSchool\Service\EportalSchoolUserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * @author OKALA
 */
class EportalSchoolUserServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new EportalSchoolUserService($serviceLocator->get('EportalSchool\Mapper\EportalSchoolUser'));
    }
}
