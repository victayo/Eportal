<?php

namespace EportalSetting\Factory\Mapper;

use EportalSetting\Mapper\EportalSettingMapper;
use EportalSetting\Model\EportalSetting;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
/**
 *
 * @author imaleo
 */
class EportalSettingMapperFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $mapper = new EportalSettingMapper();
        $mapper->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
                ->setHydrator(new ClassMethods())
                ->setEntityPrototype(new EportalSetting());
        return $mapper;
    }
}
