<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace EportalSetting;

class Module implements \Zend\ModuleManager\Feature\ServiceProviderInterface {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'EportalSetting\Mapper\EportalSetting' => function($sm) {
                    $mapper = new Mapper\EportalSettingMapper();
                    $hydrator = new \Zend\Stdlib\Hydrator\ClassMethods();
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $entity = new Model\EportalSetting();
                    $mapper->setDbAdapter($adapter)
                            ->setHydrator($hydrator)
                            ->setEntityPrototype($entity);
                    return $mapper;
                },
                'EportalSetting\Service\EportalSetting' => function($sm) {
                    $mapper = $sm->get('EportalSetting\Mapper\EportalSetting');
                    return new Service\EportalSettingService($mapper);
                }
            )
        );
    }

}
