<?php



namespace EportalSchool\Factory;

use EportalProperty\Factory\AbstractEportalPropertyUserMapperFactory;
use EportalSchool\Mapper\EportalSchoolUserMapper;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class EportalSchoolUserMapperFactory extends AbstractEportalPropertyUserMapperFactory{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $eportalSchoolMapper = $serviceLocator->get('EportalSchool\Mapper\EportalSchool');
        $mapper = new EportalSchoolUserMapper($eportalSchoolMapper);
        return $this->init($mapper, $serviceLocator);
    }
}
