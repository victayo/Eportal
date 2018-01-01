<?php

namespace EportalSetting\Factory\Service;

use EportalSetting\Service\EportalSettingService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 *
 * @author imaleo
 */
class EportalSettingServiceFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new EportalSettingService($serviceLocator->get('EportalSetting\Mapper\EportalSetting'));
    }

}
