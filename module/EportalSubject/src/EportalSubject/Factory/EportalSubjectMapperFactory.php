<?php


namespace EportalSubject\Factory;

use EportalSubject\Mapper\EportalSubjectMapper;
use Property\Factory\Mapper\AbstractRelPropertyValueMapperFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of EportalSubjectMapperFactory
 *
 * @author OKALA
 */
class EportalSubjectMapperFactory extends AbstractRelPropertyValueMapperFactory{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = new EportalSubjectMapper();
        $this->init($mapper, $serviceLocator);
        return $mapper;
    }
}
